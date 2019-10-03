<template>
    <div class="autocomplete-container">
        <input v-model="selectedOptionDisplay"
            ref="textbox"
            :class="cssClass"
            :placeholder="placeholder"
            :required="required"
            @input="search($event.target.value)"
            @focus="showOptions()"
            @blur="hideOptions()"
        />
        <slot></slot>
        <div class="col-12 invalid-feedback" v-if="error">
            {{ error }}
        </div>
        <input class="form-control" hidden v-model="selectedOptionId">
        <ul class="list-group options" :style="optionsPosition" :class="{ active: isOptionsVisible }">
            <li v-for="option in filteredOptions"
                class="list-group-item"
                :key="option.id"
                @mousedown="selectOption(option)"
            >
                {{ option[displayColumn] }}
            </li>
        </ul>
        <button type="button" @click="clearSelected()" class="autocomplete-delete" :class="{ 'active': isOptionsVisible }"><i class="fas fa-backspace"></i></button>
    </div>
</template>

<script>
    export default {
        data: () => ({
            selectedOptionDisplay: null,
            selectedOptionId: null,
            selectedOption: null,
            options: [],
            searchWord: '',
            isOptionsVisible: false,
            optionsPosition: {
                top: 0,
                left: 0,
            },
        }),
        watch: {
            value (newValue) {
                this.selectOption(newValue, false)
            },
        },
        computed: {
            filteredOptions () {
                return this.options.filter(option => {
                    const haystack = _.lowerCase(_.get(option, this.displayColumn))
                    const needle = _.lowerCase(this.searchWord)
                    return _.includes(haystack, needle)
                })
            },
        },
        methods: {
            selectOption (option, emit = true) {
                this.selectedOption = option;
                this.selectedOptionId = _.get(option, 'id')
                if (emit) {
                    this.$emit('input', this.selectedOption)
                }
            },
            clearSelected () {
                this.selectOption(null)
            },
            search (searchWord) {
                this.searchWord = searchWord
            },
            showOptions () {
                this.search('')
                this.populateOptions()
                this.updateOptionsPosition()
                this.isOptionsVisible = true
            },
            hideOptions () {
                this.selectedOptionDisplay = _.get(this.selectedOption, this.displayColumn)
                this.$emit('blur', this.selectedOption)
                this.isOptionsVisible = false
            },
            updateOptionsPosition () {
                const inputBoundingClient = this.$refs.textbox.getBoundingClientRect()
                this.optionsPosition = {
                    top: `${inputBoundingClient.top + inputBoundingClient.height}px `,
                    left: `${inputBoundingClient.left}px `,
                    width: `${inputBoundingClient.width}px `,
                }
            },
            populateOptions () {
                axios.get(`/api/${this.relation}/all`)
                    .then(response => (this.options = response.data))
            }
        },
        mounted () {
            if (this.value) {
                this.selectOption(this.value, false)
            }
        },
        props: [
            'cssClass',
            'placeholder',
            'required',
            'relation', // api to use
            'displayColumn', // column to be displayed as option
            'value',
            'error',
        ],
    }
</script>

<style scoped>
    .options {
        position: fixed;
        visibility: hidden;
        opacity: 0;
        background-color: white;
        padding: 0;
        margin: 0;
        list-style: none;
        z-index: 10;
        max-height: 291px;
        overflow-y: auto;

        transition: visibility 150ms ease-in-out,
            opacity 150ms ease-in-out;
    }

    .options.active {
        visibility: visible;
        opacity: 1;
    }

    .options li {
        cursor: pointer;
    }

    .options li:hover {
        background-color: gainsboro;
    }

    input:read-only {
        background: #fff;
    }

    .autocomplete-delete {
        position: absolute;
        background: none;
        padding: 0;
        border: 0;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        transition: all 250ms ease-in-out;

        opacity: 0;
        visibility: hidden;
    }

    .autocomplete-delete.active {
        opacity: 1;
        visibility: visible;
    }

    .autocomplete-container {
        position: relative;
    }
</style>

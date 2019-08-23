<template>
    <div class="autocomplete-container">
        <input v-model="selectedOptionDisplay"
            ref="textbox"
            :class="cssClass"
            :placeholder="placeholder"
            @focus="showOptions()"
            @blur="hideOptions()"
        />
        <input class="form-control" :name="name" hidden v-model="selectedOptionId">
        <ul class="list-group options" :style="optionsPosition" :class="{ active: isOptionsVisible }">
            <li v-for="option in options"
                class="list-group-item"
                :key="option.id"
                @mousedown="selectOption(option)"
            >
                {{ option.name }}
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        data: () => ({
            selectedOptionDisplay: null,
            selectedOptionId: null,
            selectedOption: null,
            options: [],
            isOptionsVisible: false,
            optionsPosition: {
                top: 0,
                left: 0,
            },
        }),
        methods: {
            selectOption (option) {
                this.selectedOption = option;
                this.selectedOptionDisplay = option.name;
                this.selectedOptionId = option.id
            },
            showOptions () {
                console.log(this)
                this.updateOptionsPosition()
                this.isOptionsVisible = true
            },
            hideOptions () {
                this.isOptionsVisible = false
            },
            updateOptionsPosition () {
                const inputBoundingClient = this.$refs.textbox.getBoundingClientRect()
                console.log(inputBoundingClient);
                this.optionsPosition = {
                    top: `${inputBoundingClient.top + inputBoundingClient.height}px `,
                    left: `${inputBoundingClient.left}px `,
                    width: `${inputBoundingClient.width}px `,
                }
            }
        },
        mounted () {
            axios.get('http://localhost:8000/api/companies')
                .then(response => (this.options = response.data.data))
        },
        props: [
            'cssClass',
            'name',
            'placeholder',
            'modelString',
            'relation',
        ],
    }
</script>

<style>
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
</style>

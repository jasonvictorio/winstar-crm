<template>
    <div>
        <input :class="cssClass" :name="name" :placeholder="placeholder" v-model="selectedOptionDisplay"/>
        <ul class="options">
            <li v-for="option in options"
                :key="option.id"
                @click="selectOption(option)"
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
            selectedOption: null,
            options: [],
        }),
        methods: {
            selectOption (option) {
                this.selectedOption = option;
                this.selectedOptionDisplay = option.name;
            },
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
    .options li {
        cursor: pointer;
    }
</style>

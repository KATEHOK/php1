// const API = 'http://JavaScriptSecondLevel/json';
const API = 'https://raw.githubusercontent.com/KATEHOK/JavaScriptSecondLevel/eightLesson/json';

const app = new Vue({
    el: '#app',
    components: { cart, products, filt },
    methods: {
        getJson(url) {
            return fetch(url)
                .then(result => result.json())
                .catch(() => console.error(`lost server (${url})`))
        },
    },
    mounted() {
        console.log('Working:)')
    }
});
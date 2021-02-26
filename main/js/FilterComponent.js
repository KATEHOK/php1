const filt = {
    data() {
        return {
            userSearch: '',
        }
    },
    methods: {
        filter() {
            let regexp = new RegExp(this.$data.userSearch, 'i');
            this.$root.$refs.products.$data.filtered = this.$root.$refs.products.$data.products.filter(el => regexp.test(el.product_name));
            // console.dir(this.$root.$refs.products.$data.filtered)
        }
    },
    template: `
                <form action="#" class="main-header-icons-filter main-header-icon" @submit.prevent="filter()">
                    <input v-model="userSearch" type="text" name="filt" id="filt" class="main-header-icons-filter-input"
                        placeholder="Gadget">
                    <button type="submit" class="btn">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </form>
                `
};
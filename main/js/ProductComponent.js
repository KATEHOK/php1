const product = {
    props: ['item'],
    template: `
            <div class="main-products-item">
                <img :src="item.img" alt="Photo" class="main-products-item-img">
                <span class="main-products-item-name">{{ item.product_name }}</span>
                <span class="main-products-item-price">\${{ item.price }}</span>
                <button class="main-products-item-btn btn" @click="$root.$refs.cart.addProduct(item)">buy</button>
            </div>
    `
};

const products = {
    data() {
        return {
            catalogUrl: '/catalogData.json',
            filtered: [],
            products: [],
            catalogConnection: true,
        }
    },
    components: { product },
    template: `
            <div class="main-products">
                <product v-for="item of this.$data.filtered" :key="item.id_product" :item="item"></product>
                <span class="msg" v-if="!this.$data.catalogConnection">We lost connection with server:(</span>
                <span class="msg" v-if="this.$data.catalogConnection && this.$data.filtered.length == 0">No matches:(</span>
            </div>
            `,

    mounted() {
        this.$root.getJson(`${API}${this.catalogUrl}`)
            .then(data => {
                for (let item of data) {
                    this.$data.products.push(item);
                    this.$data.filtered.push(item);
                    this.$data.catalogConnection = true;
                }
            })
            .catch(() => this.$data.catalogConnection = false);
    }
};
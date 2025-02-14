import { defineStore } from "pinia";

export const useCartStore = defineStore("cart", {
    state: () => ({
        items: [],
    }),

    getters: {
        cartCount: (state) => state.items.length,
        cartTotal: (state) =>
            state.items.reduce(
                (total, item) => total + item.price * item.quantity,
                0
            ),

        getItemQuantity: (state) => (productId) => {
            const item = state.items.find((item) => item.id === productId);
            return item ? item.quantity : 0;
        },
    },

    actions: {
        addToCart(product) {
            const existingItem = this.items.find(
                (item) => item.id === product.id
            );

            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                this.items.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    image: product.image,
                    quantity: 1,
                });
            }
        },

        removeFromCart(productId) {
            const index = this.items.findIndex((item) => item.id === productId);
            if (index > -1) {
                this.items.splice(index, 1);
            }
        },

        updateQuantity(productId, quantity) {
            const item = this.items.find((item) => item.id === productId);
            if (item) {
                item.quantity = quantity;
                if (quantity <= 0) {
                    this.removeFromCart(productId);
                }
            }
        },

        clearCart() {
            this.items = [];
        },
    },

    persist: {
        key: 'cart-storage',
        storage: localStorage,
        paths: ['items'], // only persist the items array
    },
});

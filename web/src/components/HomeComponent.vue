<template>
  <v-parallax src="https://cdn.vuetifyjs.com/images/parallax/material.jpg" height="700" style="border-radius:5em;">
  <div class="text-center">
    <h1
      class="
        mt-16
        text-[3.5rem]
        font-bold
        leading-[4rem]
        tracking-tight
        text-black
      "
    >
      Productividad en el manejo de tu información.
    </h1>
    <h2 class="mt-3 text-lg leading-relaxed text-black">
      Registra, analiza y mantente al pendiente de tus productos, ventas y
      clientes.
    </h2>
    <p class="text-black">Empieza a trabajar en uno de los siguientes modulos:</p>
    <router-link
      :to="product"
      tag="button"
      class="
        shadow-lg
        bg-gray-400
        text-black
        hover:bg-gray-300 hover:scale-105
        decoration-from-font
        rounded
        p-2
        m-1
      "
      >Modulo de productos</router-link
    >
    <router-link
      :to="orders"
      tag="button"
      class="
        shadow-lg
        bg-gray-400
        text-black
        hover:bg-gray-300 hover:scale-105
        decoration-from-font
        rounded
        p-2
        m-1
      "
      >Modulo de ordenes de compra</router-link
    >
  </div>
</v-parallax>
</template>

<script>
export default {
  name: "HomeComponent",
  data: () => ({
    product: "/product",
    customer: "/customer",
    orders: "/orders",
  }),
  computed: {
    currentUser() {
      return this.$store.state.auth.status.loggedIn;
    },
  },
  methods: {
    changeLinks() {
      if (!this.currentUser) {
        this.product = "/login";
        this.customer = "/login";
        this.orders = "/login";
      }
    },
  },
  mounted() {
    this.changeLinks();
  },
};
</script>
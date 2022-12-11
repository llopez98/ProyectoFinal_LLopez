<template>
  <v-app>
    <v-app-bar color="grey darken-3" max-height="60" dark>
      <v-app-bar-nav-icon @click="drawer = true"></v-app-bar-nav-icon>

      <v-toolbar-title>Warehouse</v-toolbar-title>
      <v-spacer></v-spacer>
      <div v-if="currentUser">
        <v-btn color="white accent-4" text :href="product">
          <span>Productos</span>

          <v-icon>mdi-warehouse</v-icon>
        </v-btn>
        <v-btn color="white accent-4" text :href="orders">
          <span>Ordenes de compra</span>

          <v-icon>mdi-store</v-icon>
        </v-btn>
      </div>
      <div v-else>
        <v-btn color="white accent-4" text :href="register">
          <span>Registrate</span>

          <v-icon>mdi-account-box</v-icon>
        </v-btn>
      </div>
    </v-app-bar>

    <v-navigation-drawer v-model="drawer" absolute temporary>
      <v-list nav dense>
        <v-list-item-group
          v-model="group"
          active-class="deep-purple--text text--accent-4"
        >
          <v-list-item :href="home">
            <v-list-item-icon>
              <v-icon>mdi-home</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Home</v-list-item-title>
          </v-list-item>

          <v-list-item v-if="currentUser" @click="logOut">
            <v-list-item-icon>
              <v-icon>mdi-logout</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Logout</v-list-item-title>
          </v-list-item>
          <v-list-item v-else :href="login">
            <v-list-item-icon>
              <v-icon>mdi-login</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Login</v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>

    <v-main class="bg-gray-50">
      <router-view class="container mx-auto px-4" />
    </v-main>
  </v-app>
</template>

<script>
import eventBus from "./common/eventBus";

export default {
  name: "App",

  data: () => ({
    drawer: false,
    group: null,
    home: "#/",
    product: "#/product",
    orders: "#/orders",
    register: "#/register",
    login: "#/login",
  }),
  computed: {
    currentUser() {
      return this.$store.state.auth.user;
    },
  },
  methods: {
    logOut() {
      this.$store.dispatch("logout");
      this.$router.push("/login");
    },
  },
  mounted() {
    eventBus.on("logout", () => {
      this.logOut();
    });
  },
  beforeDestroy() {
    eventBus.remove("logout");
  },
};
</script>

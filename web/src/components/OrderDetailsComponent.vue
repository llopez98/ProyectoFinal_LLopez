<template>
  <v-card>
    <v-card-title>
      <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details>
      </v-text-field>
    </v-card-title>
    <v-data-table :headers="headers" :items="orderDetails" :search="search" :loading="load"
      loading-text="Loading... Please wait">
      <template v-slot:top>
        <v-toolbar flat>
          <v-dialog v-model="dialogDelete" max-width="600px">
            <v-card>
              <v-card-title class="text-h5">¿Esta seguro de borrar esta orden de compra?</v-card-title>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>

      <template v-slot:[`item.actions`]="{ item }">
        <v-icon v-if="superUser" small @click="deleteItem(item)"> mdi-delete </v-icon>
      </template>
    </v-data-table>
  </v-card>
</template>
<script>
import ordersService from "@/services/orders.service";

export default {
  name: "OrderDetailsComponent",
  props: {
    orderId: Number,
  },
  data() {
    return {
      load: true,
      dialogDelete: false,
      itemToDel: "",
      search: "",
      headers: [
        {
          text: "ID",
          align: "start",
          filterable: false,
          value: "id",
        },
        { text: "Nombre del Producto", value: "nombre" },
        { text: "Nombre del cliente", value: "cliente" },
        { text: "Cantidad del producto", value: "cantidad" },
        { text: "Precio", value: "precio" },
        { text: "ITBMS", value: "itbms" },
        { text: "Precio Total", value: "precio_total" },
        { text: "Actions", value: "actions", sortable: false },
      ],
      orderDetails: [],
      superUser: false,
    };
  },
  watch: {
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },
  computed: {
    loggedIn() {
      return this.$store.state.auth.user[0].tipo;
    },
  },
  methods: {
    async getOrderDetails() {
      const response = await ordersService.GetOrderDetails(this.orderId);
      this.orderDetails = response.data.records;
      this.load = false;
    },
    closeDelete() {
      this.dialogDelete = false;
    },
    deleteItem(item) {
      this.itemToDel = item.id;
      this.dialogDelete = true;
    },
    deleteItemConfirm() {
      ordersService.DeleteOrder(this.itemToDel);
      this.dialogDelete = false;
    },
    checkUser(){
      if(this.loggedIn === "superUser"){
        this.superUser = true;
      }
    }
  },
  mounted() {
    this.getOrderDetails();
    this.checkUser();
  },
};
</script>
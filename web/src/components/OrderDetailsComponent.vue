<template>
  <v-card>
    <v-card-title>
      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Search"
        single-line
        hide-details
      >
      </v-text-field>
    </v-card-title>
    <v-data-table
      :headers="headers"
      :items="orderDetails"
      :search="search"
      :loading="load"
      loading-text="Loading... Please wait"
    >
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
    };
  },
  methods: {
    async getOrderDetails() {
      const response = await ordersService.GetOrderDetails(this.orderId);
      this.orderDetails = response.data.records;
      this.load = false;
    },
  },
  mounted() {
    this.getOrderDetails();
  },
};
</script>
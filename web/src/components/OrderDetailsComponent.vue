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
          value: "salesOrderDetailId",
        },
        { text: "Order Qty", value: "orderQty" },
        { text: "ID del producto", value: "productId" },
        { text: "Precio por unidad", value: "unitPrice" },
        { text: "Descuento", value: "unitPriceDiscount" },
        { text: "Total", value: "lineTotal" },
      ],
      orderDetails: [],
    };
  },
  methods: {
    async getOrderDetails() {
      const response = await ordersService.GetOrderDetails(this.orderId);
      this.orderDetails = response.data;
      this.load = false;
    },
  },
  mounted() {
    this.getOrderDetails();
  },
};
</script>
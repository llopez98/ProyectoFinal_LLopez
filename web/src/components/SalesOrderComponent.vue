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
      :items="orders"
      :search="search"
      :loading="load"
      loading-text="Loading... Please wait"
      @click:row="openDetails"
      item-key="item"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-dialog v-model="dialogDetails" max-width="750px" persistent>
            <div v-if="dialogDetails">
              <order-details-component :orderId="order.salesOrderId" />
            </div>
            <v-btn block @click="closeDetails">Ok</v-btn>
          </v-dialog>
        </v-toolbar>
        <v-spacer></v-spacer>
      </template>
    </v-data-table>
  </v-card>
</template>
<script>
import ordersService from "@/services/orders.service";
const OrderDetailsComponent = () => import("@/components/OrderDetailsComponent.vue");
//import OrderDetailsComponent from "@/components/OrderDetailsComponent.vue";

export default {
  name: "SalesOrderComponent",
  components: {
    OrderDetailsComponent,
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
          value: "salesOrderId",
        },
        { text: "Número de revisión", value: "revisionNumber" },
        { text: "Order Date", value: "orderDate" },
        { text: "Due Date", value: "dueDate" },
        { text: "Ship Date", value: "shipDate" },
        { text: "Estado", value: "status" },
        { text: "Id del cliente", value: "customerId" },
        { text: "Ship Method", value: "shipMethod" },
        { text: "Total", value: "totalDue" },
      ],
      orders: [],
      order: "",
      dialogDetails: false,
    };
  },
  methods: {
    async getOrders() {
      const response = await ordersService.GetAllOrders();
      this.orders = response.data;
      this.load = false;
    },
    openDetails(item) {
      this.dialogDetails = true;
      this.order = item;
    },
    closeDetails() {
      this.dialogDetails = false;
    },
  },
  mounted() {
    this.getOrders();
  },
};
</script>
<template>
  <v-card class="mt-4">
    <h1
      class="
        mt-16
        text-[2.5rem]
        font-bold
        leading-[4rem]
        tracking-tight
        text-slate-700
      "
    >
      Modulo de ordenes de compra.
    </h1>
    <v-card-title>
      <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details>
      </v-text-field>
    </v-card-title>
    <v-data-table :headers="headers" :items="orders" :search="search" :loading="load"
      loading-text="Loading... Please wait" @click:row="openDetails" item-key="item">
      <template v-slot:top>
        <v-toolbar flat>
          <v-btn color="secundary" dark class="mb-2" @click="createItem">
            Nueva orden de compra
          </v-btn>
          <v-dialog v-model="dialogDetails" max-width="750px" persistent>
            <div v-if="dialogDetails">
              <order-details-component :orderId="order.id" />
            </div>
            <v-btn block @click="closeDetails">Ok</v-btn>
          </v-dialog>
          <v-dialog v-model="dialogCreate" max-width="750px">
            <ValidationObserver v-slot="{ handleSubmit }" ref="editForm">
              <v-form @submit.prevent="handleSubmit(createItemConfirm)">
                <v-card>
                  <v-card-title class="text-h5">Nueva orden de compra</v-card-title>
                  <v-container class="px-16 mt-10">
                    <v-row>
                      <v-col>
                        <ValidationProvider name="Id del producto" rules="required" v-slot="{ errors }">
                          <v-text-field v-model="newItem.id_producto" label="Id del producto" placeholder="001"
                            name="name" filled rounded dense>
                          </v-text-field>
                          <v-alert v-if="errors[0]" dense outlined type="error">
                            {{ errors[0] }}
                          </v-alert>
                        </ValidationProvider>
                      </v-col>
                      <v-col>
                        <ValidationProvider name="Nombre del Cliente" rules="required" v-slot="{ errors }">
                          <v-text-field v-model="newItem.cliente" label="Nombre del cliente" name="productNumber"
                            placeholder="Nombre del cliente" filled rounded dense></v-text-field>
                          <v-alert v-if="errors[0]" dense outlined type="error">
                            {{ errors[0] }}
                          </v-alert>
                        </ValidationProvider>
                      </v-col>
                    </v-row>
                    <v-row>
                      <v-col>
                        <ValidationProvider name="Cantidad" rules="required" v-slot="{ errors }">
                          <v-text-field v-model="newItem.cantidad" label="Cantidad" name="cantidad" placeholder="10"
                            filled rounded dense></v-text-field>
                          <v-alert v-if="errors[0]" dense outlined type="error">
                            {{ errors[0] }}
                          </v-alert>
                        </ValidationProvider>
                      </v-col>
                    </v-row>
                    <v-row>
                      <v-col>
                        <ValidationProvider name="Precio" rules="required" v-slot="{ errors }">
                          <v-text-field v-model="newItem.precio" label="Precio" name="precio" placeholder="00.00" filled
                            rounded dense></v-text-field>
                          <v-alert v-if="errors[0]" dense outlined type="error">
                            {{ errors[0] }}
                          </v-alert>
                        </ValidationProvider>
                      </v-col>
                      <v-col>
                        <ValidationProvider name="Itbms" rules="required" v-slot="{ errors }">
                          <v-text-field v-model="newItem.itbms" label="ITBMS" name="itbms" placeholder="00.00" filled
                            rounded dense></v-text-field>
                          <v-alert v-if="errors[0]" dense outlined type="error">
                            {{ errors[0] }}
                          </v-alert>
                        </ValidationProvider>
                      </v-col>
                    </v-row>
                    <v-row>
                      <v-col>
                        <ValidationProvider name="Precio Total" rules="required" v-slot="{ errors }">
                          <v-text-field v-model="newItem.precio_total" label="Precio Total" name="precio_total"
                            placeholder="00.00" filled rounded dense></v-text-field>
                          <v-alert v-if="errors[0]" dense outlined type="error">
                            {{ errors[0] }}
                          </v-alert>
                        </ValidationProvider>
                      </v-col>

                    </v-row>
                  </v-container>

                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" outlined text @click="closeCreate">Cancel</v-btn>
                    <v-btn color="blue darken-1" outlined text type="submit" @click="createItemConfirm">OK</v-btn>
                    <v-spacer></v-spacer>
                  </v-card-actions>
                </v-card>
              </v-form>
            </ValidationObserver>
          </v-dialog>
        </v-toolbar>
        <v-spacer></v-spacer>
      </template>
    </v-data-table>

  </v-card>
</template>
<script>
import ordersService from "@/services/orders.service";
import { ValidationProvider, ValidationObserver } from "vee-validate";
const OrderDetailsComponent = () => import("@/components/OrderDetailsComponent.vue");

export default {
  name: "SalesOrderComponent",
  components: {
    ValidationProvider,
    ValidationObserver,
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
          value: "id",
        },
        { text: "Id del producto", value: "id_producto" },
        { text: "Nombre del Cliente", value: "cliente" },
        { text: "Cantidad del articulo", value: "cantidad" },
        { text: "Precio", value: "precio" },
        { text: "ITBMS", value: "itbms" },
        { text: "Precio Total", value: "precio_total" },
      ],
      orders: [],
      order: "",
      dialogDetails: false,
      dialogCreate: false,
      newItem: {}
    };
  },
  methods: {
    async getOrders() {
      const response = await ordersService.GetAllOrders();
      this.orders = response.data.records;
      this.load = false;
    },
    openDetails(item) {
      this.dialogDetails = true;
      this.order = item;
    },
    closeDetails() {
      this.dialogDetails = false;
    },
    closeCreate() {
      this.dialogCreate = false;
    },
    createItem() {
      this.dialogCreate = true;
    },
    createItemConfirm() {
      ordersService.CreateOrder(this.newItem);
      this.newItem = {};
      this.dialogCreate = false;
    },
  },
  mounted() {
    this.getOrders();
  },
};
</script>
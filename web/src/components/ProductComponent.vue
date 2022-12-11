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
      :items="products"
      :search="search"
      :loading="load"
      loading-text="Loading... Please wait"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="text-h5"
                >¿Esta seguro de borrar este producto?</v-card-title
              >
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="closeDelete"
                  >Cancel</v-btn
                >
                <v-btn color="blue darken-1" text @click="deleteItemConfirm"
                  >OK</v-btn
                >
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
          <v-dialog v-model="dialogEdit" max-width="750px">
            <ValidationObserver v-slot="{ handleSubmit }" ref="editForm">
              <v-form @submit.prevent="handleSubmit(editItemConfirm)">
                <v-card>
                  <v-card-title class="text-h5">Editar Producto</v-card-title>
                  <v-container class="px-16 mt-10">
                    <v-row>
                      <v-col>
                        <ValidationProvider
                          name="Name"
                          rules="required"
                          v-slot="{ errors }"
                        >
                          <v-text-field
                            v-model="itemToEdit.nombre"
                            label="Nombre"
                            placeholder="Name"
                            name="name"
                            filled
                            rounded
                            dense
                          >
                          </v-text-field>
                          <v-alert v-if="errors[0]" dense outlined type="error">
                            {{ errors[0] }}
                          </v-alert>
                        </ValidationProvider>
                      </v-col>
                      <v-col>
                        <ValidationProvider
                          name="ProductNumber"
                          rules="required"
                          v-slot="{ errors }"
                        >
                          <v-text-field
                            v-model="itemToEdit.numero_producto"
                            label="Numero del producto"
                            name="productNumber"
                            placeholder="ProductNumber"
                            filled
                            rounded
                            dense
                          ></v-text-field>
                          <v-alert v-if="errors[0]" dense outlined type="error">
                            {{ errors[0] }}
                          </v-alert>
                        </ValidationProvider>
                      </v-col>
                    </v-row>
                    <v-row>
                      <v-col>
                        <ValidationProvider
                          name="Color"
                          rules="required"
                          v-slot="{ errors }"
                          >
                          <v-select
                            :items="colors"
                            v-model="itemToEdit.color"
                            name="color"
                            label="Color"
                            filled
                            rounded
                            dense
                          ></v-select>
                          <v-alert v-if="errors[0]" dense outlined type="error">
                            {{ errors[0] }}
                          </v-alert>
                        </ValidationProvider>
                      </v-col>
                    </v-row>
                    <v-row>
                      <v-col>
                        <ValidationProvider
                          name="standardCost"
                          rules="required"
                          v-slot="{ errors }"
                        >
                          <v-text-field
                            v-model="itemToEdit.precio_unitario"
                            type="number"
                            label="Precio Unitario"
                            name="standardCost"
                            placeholder="StandardCost"
                            filled
                            rounded
                            dense
                          ></v-text-field>
                          <v-alert v-if="errors[0]" dense outlined type="error">
                            {{ errors[0] }}
                          </v-alert>
                        </ValidationProvider>
                      </v-col>
                      <v-col>
                        <ValidationProvider
                          name="listPrice"
                          rules="required"
                          v-slot="{ errors }"
                        >
                          <v-text-field
                            v-model="itemToEdit.cantidad_inventario"
                            type="number"
                            label="Cantidad en Inventario"
                            name="listPrice"
                            placeholder="ListPrice"
                            filled
                            rounded
                            dense
                          ></v-text-field>
                          <v-alert v-if="errors[0]" dense outlined type="error">
                            {{ errors[0] }}
                          </v-alert>
                        </ValidationProvider>
                      </v-col>
                    </v-row>
                  </v-container>

                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                      color="blue darken-1"
                      outlined
                      text
                      @click="closeEdit"
                      >Cancel</v-btn
                    >
                    <v-btn
                      color="blue darken-1"
                      outlined
                      text
                      type="submit"
                      @click="editItemConfirm"
                      >OK</v-btn
                    >
                    <v-spacer></v-spacer>
                  </v-card-actions>
                </v-card>
              </v-form>
            </ValidationObserver>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:[`item.thumbNailPhoto`]="{ item }">
        <div class="p-2">
          <img v-bind:src="'data:image/gif;base64,' + item.thumbNailPhoto" />
        </div>
      </template>
      <template v-slot:[`item.actions`]="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
        <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
      </template>
    </v-data-table>
  </v-card>
</template>
<script>
import productsService from "@/services/products.service";
import { ValidationProvider, ValidationObserver } from "vee-validate";

export default {
  name: "ProductComponent",
  components: {
    ValidationProvider,
    ValidationObserver,
  },
  data() {
    return {
      load: true,
      dialogDelete: false,
      dialogEdit: false,
      menu1: false,
      menu2: false,
      menu3: false,
      itemToDel: "",
      itemToEdit: {
        nombre: "",
        numero_producto: "",
        color: "",
        precio_unitario: "",
        cantidad_inventario: "",
      },
      colors: [
        "Black",
        "Red",
        "White",
        "Blue",
        "Yellow",
        "Grey",
        "Silver",
        "Multi",
      ],
      search: "",
      headers: [
      {
          text: "ID",
          align: "start",
          filterable: false,
          value: "id",
        },
        { text: "Nombre", value: "nombre" },
        { text: "Número del producto", value: "numero_producto" },
        { text: "Color", value: "color" },
        { text: "Precio Unitario", value: "precio_unitario" },
        { text: "Cantidad en inventario", value: "cantidad_inventario" },
        { text: "Actions", value: "actions", sortable: false },
      ],
      products: [],
    };
  },
  watch: {
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },
  methods: {
    async getProducts() {
      const response = await productsService.GetAllProducts();
      this.products = response.data.records;
      this.load = false;
    },
    closeDelete() {
      this.dialogDelete = false;
    },
    deleteItem(item) {
      this.itemToDel = item.productId;
      this.dialogDelete = true;
    },
    deleteItemConfirm() {
      productsService.DeleteProduct(this.itemToDel);
      this.getProducts();
      this.dialogDelete = false;
    },
    closeEdit() {
      this.dialogEdit = false;
    },
    editItem(item) {
      this.itemToEdit = item;
      this.dialogEdit = true;
    },
    editItemConfirm() {
      productsService.EditProduct(this.itemToEdit);
      this.getProducts();
      this.itemToEdit = {};
      this.dialogEdit = false;
    },
  },
  mounted() {
    this.getProducts();
  },
};
</script>
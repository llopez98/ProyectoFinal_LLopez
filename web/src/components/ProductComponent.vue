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
              <v-form @submit.prevent="handleSubmit(submitEdit)">
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
                            v-model="itemToEdit.name"
                            label="Name"
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
                            v-model="itemToEdit.productNumber"
                            label="ProductNumber"
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
                          ><!--
                      <v-text-field
                        v-model="itemToEdit.color"
                        label="Color"
                        name="color"
                        placeholder="Color"
                        filled
                        rounded
                        dense
                      ></v-text-field>-->
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
                            v-model="itemToEdit.standardCost"
                            type="number"
                            label="StandardCost"
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
                            v-model="itemToEdit.listPrice"
                            type="number"
                            label="ListPrice"
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
                    <v-row>
                      <v-col>
                        <ValidationProvider
                          name="size"
                          rules="required"
                          v-slot="{ errors }"
                        >
                          <v-text-field
                            v-model="itemToEdit.size"
                            label="Size"
                            name="size"
                            placeholder="Size"
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
                          name="weight"
                          rules="required"
                          v-slot="{ errors }"
                        >
                          <v-text-field
                            v-model="itemToEdit.weight"
                            type="number"
                            label="Weight"
                            name="weight"
                            placeholder="Weight"
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
                          name="productCategoryId"
                          rules="required"
                          v-slot="{ errors }"
                        >
                          <v-select
                            :items="categories"
                            v-model="itemToEdit.productCategoryId"
                            name="productCategoryId"
                            label="ProductCategoryId"
                            item-value="productCategoryId"
                            item-text="name"
                            filled
                            rounded
                            dense
                          ></v-select>
                          <v-alert v-if="errors[0]" dense outlined type="error">
                            {{ errors[0] }}
                          </v-alert>
                        </ValidationProvider>
                      </v-col>
                      <v-col>
                        <ValidationProvider
                          name="productModelId"
                          rules="required"
                          v-slot="{ errors }"
                        >
                          <v-text-field
                            v-model="itemToEdit.productModelId"
                            label="ProductModelId"
                            name="productModelId"
                            placeholder="ProductModelId"
                            filled
                            rounded
                            dense
                            disabled
                          ></v-text-field>
                          <v-alert v-if="errors[0]" dense outlined type="error">
                            {{ errors[0] }}
                          </v-alert>
                        </ValidationProvider>
                      </v-col>
                    </v-row>
                    <ValidationProvider
                      name="sellStartDate"
                      rules="required"
                      v-slot="{ errors }"
                    >
                      <v-menu
                        v-model="menu1"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                      >
                        <template v-slot:activator="{ on, attrs }">
                          <v-text-field
                            v-model="itemToEdit.sellStartDate"
                            label="Sell Start Date"
                            name="sellStartDate"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                          ></v-text-field>
                        </template>
                        <v-date-picker
                          v-model="itemToEdit.sellStartDate"
                          @input="menu1 = false"
                        ></v-date-picker>
                      </v-menu>
                      <v-alert v-if="errors[0]" dense outlined type="error">
                        {{ errors[0] }}
                      </v-alert>
                    </ValidationProvider>
                    <ValidationProvider
                      name="sellEndDate"
                      rules="required"
                      v-slot="{ errors }"
                    >
                      <v-menu
                        v-model="menu2"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                      >
                        <template v-slot:activator="{ on, attrs }">
                          <v-text-field
                            v-model="itemToEdit.sellEndDate"
                            label="Sell End Date"
                            name="sellEndDate"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                          ></v-text-field>
                        </template>
                        <v-date-picker
                          v-model="itemToEdit.sellEndDate"
                          @input="menu2 = false"
                        ></v-date-picker>
                      </v-menu>
                      <v-alert v-if="errors[0]" dense outlined type="error">
                        {{ errors[0] }}
                      </v-alert>
                    </ValidationProvider>
                    <ValidationProvider
                      name="discontinuedDate"
                      rules="required"
                      v-slot="{ errors }"
                    >
                      <v-menu
                        v-model="menu3"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                      >
                        <template v-slot:activator="{ on, attrs }">
                          <v-text-field
                            v-model="itemToEdit.discontinuedDate"
                            label="Discontinued Date"
                            name="discontinuedDate"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                          ></v-text-field>
                        </template>
                        <v-date-picker
                          v-model="itemToEdit.discontinuedDate"
                          @input="menu3 = false"
                        ></v-date-picker>
                      </v-menu>
                      <v-alert v-if="errors[0]" dense outlined type="error">
                        {{ errors[0] }}
                      </v-alert>
                    </ValidationProvider>
                    <!--<v-btn
                    color="success"
                    class="mr-4"
                    :disabled="invalid"
                    type="submit"
                  >
                    Guardar camb
                  </v-btn>

                  <v-alert v-if="message" border="right" colored-border type="error" elevation="2">
                Complete todos los campos!
            </v-alert>-->
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
        name: "",
        productNumber: "",
        color: "",
        standardCost: "",
        listPrice: "",
        size: "",
        weight: "",
        productCategoryId: "",
        productModelId: "",
        sellStartDate: "",
        sellEndDate: "",
        discontinuedDate: "",
        thumbNailPhoto: "",
        thumbNailPhotoFileName: "",
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
      categories: [
        {
          productCategoryId: "",
        },
      ],
      search: "",
      headers: [
        {
          text: "ID",
          align: "start",
          filterable: false,
          value: "productId",
        },
        { text: "Nombre", value: "name" },
        { text: "Número del producto", value: "productNumber" },
        { text: "ListPrice", value: "listPrice" },
        { text: "Tamaño", value: "size" },
        { text: "Peso", value: "weight" },
        { text: "Categoria del Producto", value: "ProductCategory" },
        { text: "Foto", value: "thumbNailPhoto" },
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
      this.products = response.data;
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
      const response = productsService.DeleteProduct(this.itemToDel);
      if (response) {
        this.getProducts();
      }
      this.dialogDelete = false;
    },
    closeEdit() {
      this.dialogEdit = false;
    },
    async editItem(item) {
      this.itemToEdit = item;
      const response = await productsService.GetProductCategories();
      this.categories = response.data;
      this.dialogEdit = true;
    },
    editItemConfirm() {
      const response = productsService.EditProduct(this.itemToEdit);
      if (response) {
        this.getProducts();
      }
      this.itemToEdit = {};
      this.dialogEdit = false;
    },
  },
  mounted() {
    this.getProducts();
  },
};
</script>
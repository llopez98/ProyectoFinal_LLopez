<template>
  <ValidationObserver v-slot="{ handleSubmit }" ref="registerForm">
    <v-form @submit.prevent="handleSubmit(handleRegister)">
      <v-container class="px-16 mt-10">
        <ValidationProvider
          name="Email"
          rules="required|validMail"
          v-slot="{ errors }"
        >
          <v-text-field
            v-model="user.nombre"
            label="Email"
            placeholder="Email"
            name="email"
            filled
            rounded
            dense
          >
          </v-text-field>
          <v-alert v-if="errors[0]" dense outlined type="error">
            {{ errors[0] }}
          </v-alert>
        </ValidationProvider>

        <ValidationProvider
          name="Contraseña"
          rules="required|confirmed:confirmPassword"
          v-slot="{ errors }"
        >
          <v-text-field
            v-model="user.contrasena"
            :type="'password'"
            label="Password"
            name="password"
            placeholder="Password"
            filled
            rounded
            dense
          ></v-text-field>
          <v-alert v-if="errors[0]" dense outlined type="error">
            {{ errors[0] }}
          </v-alert>
        </ValidationProvider>

        <ValidationProvider
          name="Contraseña"
          rules="required"
          v-slot="{ errors }"
          vid="confirmPassword"
        >
          <v-text-field
            v-model="user.contrasenaConfirm"
            :type="'password'"
            label="Confirm Password"
            name="confirmPassword"
            placeholder="Confirm Password"
            filled
            rounded
            dense
          ></v-text-field>
          <v-alert v-if="errors[0]" dense outlined type="error">
            {{ errors[0] }}
          </v-alert>
        </ValidationProvider>

        <v-btn color="info" class="mr-4" type="submit"> Registrar </v-btn>

        <v-alert
          v-if="message"
          border="right"
          colored-border
          type="error"
          elevation="2"
        >
          Complete todos los campos!
        </v-alert>
      </v-container>
    </v-form>
  </ValidationObserver>
</template>
<script>
import UserRegister from "@/models/userRegister";
import { ValidationProvider, ValidationObserver } from "vee-validate";

export default {
  name: "RegisterComponent",
  components: {
    ValidationProvider,
    ValidationObserver,
  },
  data() {
    return {
      user: new UserRegister(),
      message: "",
    };
  },
  computed: {
    loggedIn() {
      return this.$store.state.auth.loggedIn;
    },
  },
  created() {
    if (this.loggedIn) {
      this.$router.push("/home");
    }
  },
  methods: {
    handleRegister() {
      if (this.user.nombre && this.user.contrasena && this.user.contrasenaConfirm) {
        this.$store.dispatch("register", this.user).then(
          () => {
            this.$router.push("/login");
          },
          (error) => {
            this.message =
              (error.response && error.response.data) ||
              error.message ||
              error.toString();
          }
        );
      }
    },
  },
};
</script>
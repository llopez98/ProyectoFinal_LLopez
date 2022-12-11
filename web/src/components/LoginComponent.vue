<template>
  <ValidationObserver v-slot="{ handleSubmit }" ref="loginForm">
    <v-form @submit.prevent="handleSubmit(handleLogin)">
      <v-container class="px-16 mt-10">
        <ValidationProvider name="Email" rules="required|validMail" v-slot="{ errors }">
          <v-text-field v-model="user.nombre" label="Email" placeholder="Email" name="email" filled rounded dense>
          </v-text-field>
          <v-alert v-if="errors[0]" dense outlined type="error">
            {{ errors[0] }}
          </v-alert>
        </ValidationProvider>

        <ValidationProvider name="Contraseña" rules="required" v-slot="{ errors }">
          <v-text-field :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'" :type="show ? 'text' : 'password'"
            v-model="user.contrasena" label="Password" name="password" placeholder="Password" filled rounded dense
            @click:append="show = !show"></v-text-field>
          <v-alert v-if="errors[0]" dense outlined type="error">
            {{ errors[0] }}
          </v-alert>
        </ValidationProvider>

        <v-btn color="info" class="mr-4" type="submit" large> Login </v-btn>

        <v-alert v-if="message" border="right" colored-border type="error" elevation="2">
          Complete todos los campos!
        </v-alert>
      </v-container>
    </v-form>
  </ValidationObserver>
</template>
<script>
import User from "../models/user";
import { ValidationProvider, ValidationObserver } from "vee-validate";

export default {
  name: "LoginComponent",
  components: {
    ValidationProvider,
    ValidationObserver,
  },
  data() {
    return {
      user: new User(),
      message: false,
      show: false,
    };
  },
  computed: {
    loggedIn() {
      return this.$store.state.auth.loggedIn;
    },
  },
  created() {
    if (this.loggedIn) {
      this.$router.push("/");
    }
  },
  methods: {
    handleLogin() {
      if (this.user.nombre && this.user.contrasena) {
        this.$store.dispatch("login", this.user).then((user) => {
          if(user.length >0)
            this.$router.push("/");
          else
            this.$router.push("/register");
        }
        );
      }
    },
  },
};
</script>
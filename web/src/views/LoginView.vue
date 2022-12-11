<template>
  <div>
    <h3 class="mt-16 text-[2rem] text-center">Bienvenido, Inicia sesión!</h3>
    <LoginComponent />
  </div>
</template>
<script>
const LoginComponent = () => import("@/components/LoginComponent.vue");
//import LoginComponent from "@/components/LoginComponent.vue";

export default {
  name: "LoginView",
  components: {
    LoginComponent,
  },
};
</script>

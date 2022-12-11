<template>
  <div>
    <h3 class="mt-16 text-[2rem] text-center">Registrate hoy!</h3>
    <RegisterComponent />
  </div>
</template>
<script>
const RegisterComponent = () => import("@/components/RegisterComponent.vue");

export default {
  name: "RegisterView",
  components: {
    RegisterComponent,
  },
};
</script>

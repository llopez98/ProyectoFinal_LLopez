import { extend } from "vee-validate";
import { required, confirmed } from "vee-validate/dist/rules";

extend("required", required);

extend("validMail", (email) => {
  if (email.includes("@")) {
    return true;
  }
  return "El campo {_field_} debe ser un correo valido!";
});

extend("confirmed", {
  ...confirmed,
  message: "Las contraseñas no coinciden",
});
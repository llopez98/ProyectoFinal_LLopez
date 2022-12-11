import apiService from "./api.service";

class AuthService {
  registrar(user) {
    return apiService.post("proyecto_final_llopez/api/usuario/loguear.php", {
      nombre: user.nombre,
      contrasena: user.contrasena,
      tipo: user.tipo,
    });
  }

  login(user) {
    return apiService
      .post("proyecto_final_llopez/api/usuario/loguear.php", {
        nombre: user.nombre,
        contrasena: user.contrasena,
      })
      .then((response) => {
        if (response.data.records.length >0) {
          localStorage.setItem("user", JSON.stringify(response.data.records));
        }
        return response.data.records;
      });
  }

  logout() {
    localStorage.removeItem("user");
  }
}

export default new AuthService();

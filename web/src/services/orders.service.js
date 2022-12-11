import apiService from "./api.service";

class OrderService {
  GetAllOrders() {
    return apiService
      .get("proyecto_final_llopez/api/ordenes/leer.php", null)
      .then((response) => {
        return Promise.resolve(response);
      })
      .catch((error) => {
        console.log(error);
      });
  }

  GetOrderDetails(id) {
    return apiService
      .post("proyecto_final_llopez/api/ordenes/leer_uno.php", {
        id: id,
      })
      .then((response) => {
        return Promise.resolve(response);
      })
      .catch((error) => {
        console.log(error);
      });
  }

  DeleteOrder(id) {
    return apiService
      .post("proyecto_final_llopez/api/ordenes/eliminar.php", {
        id: id,
      })
      .then((response) => {
        console.log(response);
        return true;
      })
      .catch((error) => {
        console.log(error);
        return false;
      });
  }

  CreateOrder(item) {
    return apiService
      .post("proyecto_final_llopez/api/ordenes/registrar.php", item)
      .then((response) => {
        console.log(response);
        return true;
      })
      .catch((error) => {
        console.log(error);
        return false;
      });
  }
}

export default new OrderService();

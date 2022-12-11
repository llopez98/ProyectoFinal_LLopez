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
}

export default new OrderService();

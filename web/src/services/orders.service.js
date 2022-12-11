import apiService from "./api.service";

class OrderService {
  GetAllOrders() {
    return apiService
      .get("leer", null)
      .then((response) => {
        return Promise.resolve(response);
      })
      .catch((error) => {
        console.log(error);
      });
  }

  GetOrderDetails(id) {
    return apiService
      .post("leer_uno", {
        id: id,
      })
      .then((response) => {
        return response.data;
      });
  }
}

export default new OrderService();

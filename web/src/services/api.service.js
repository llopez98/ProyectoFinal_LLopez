import axios from "axios";

const instance = axios.create({
    baseURL: "http://localhost:80/",
    headers:{
        "Content-Type": "application/json",
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Headers": "*"
    },
    responseType: 'json'
});

export default instance;

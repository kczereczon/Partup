import axios from "axios";

export default axios.create({
    baseURL: process.env.APP_URL
        ? process.env.APP_URL + "/api"
        : "http://localhost:8000/api",
    headers: {
        Authorization: "Bearer " + window.localStorage.getItem("authToken"),
    },
});

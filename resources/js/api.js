import axios from "axios";

export default axios.create({
    baseURL: "/api",
    headers: {
        Authorization: "Bearer " + window.localStorage.getItem("authToken"),
    },
});

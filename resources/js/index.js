window.addEventListener("load", () => {
    const modules = document.querySelectorAll(".module");
    modules.forEach((module) => {
        module.addEventListener("click", (e) => {
            const moduleId = e.target.parentNode.dataset.moduleid;
            setSelection(e.target.parentNode);

            getModuleHistory(moduleId).then((res) => {
                setTemperatureChart(res);
                setSpeedChart(res);
            });
            getModuleInfo(moduleId).then((res) => {
                setModuleInfo(res);
            });
        });
    });

    getModuleTypes().then((res) => {
        console.log(res);
        initPieChart(res);
    });
});

const setSelection = (element) => {
    const modules = document.querySelectorAll(".module");
    modules.forEach((module) => {
        module.classList.toggle("selected", module == element);
    });
};
const setTemperatureChart = (data) => {
    const ctx = document.getElementById("temperatureChart").getContext("2d");
    document
        .getElementById("temperature")
        .firstElementChild.classList.remove("d-none");
    document
        .getElementById("temperature")
        .lastElementChild.classList.add("d-none");

    let chartStatus = Chart.getChart("temperatureChart"); // <canvas> id
    if (chartStatus != undefined) {
        chartStatus.destroy();
    }
    const myChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: data.map((item) => {
                let date = new Date(item.created_at);
                return `${date.getHours()}:${date.getMinutes()}`;
            }),
            datasets: [
                {
                    label: "Temperature",
                    data: data.map((item) => item.temperature),
                    backgroundColor: "rgba(255, 99, 132, 0.2)",
                    borderColor: "rgba(255, 99, 132, 1)",
                    borderWidth: 1,
                },
            ],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
};

const setSpeedChart = (data) => {
    const ctx = document.getElementById("speedChart").getContext("2d");

    document
    .getElementById("speed")
    .firstElementChild.classList.remove("d-none");
document
    .getElementById("speed")
    .lastElementChild.classList.add("d-none");

    let chartStatus = Chart.getChart("speedChart"); // <canvas> id
    if (chartStatus != undefined) {
        chartStatus.destroy();
    }
    const myChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: data.map((item) => {
                let date = new Date(item.created_at);
                return `${date.getHours()}:${date.getMinutes()}`;
            }),
            datasets: [
                {
                    label: "Speed",
                    data: data.map((item) => item.speed),
                    backgroundColor: "rgba(255, 99, 132, 0.2)",
                    borderColor: "rgba(255, 99, 132, 1)",
                    borderWidth: 1,
                },
            ],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
};

const setModuleInfo = (data) => {
    if (data == null) return;

    console.log(data);
    const moduleInfo = document.querySelector(".module-info");
    console.log(moduleInfo);
    moduleInfo.firstElementChild.classList.remove("d-none");
    moduleInfo.lastElementChild.classList.add("d-none");

    const moduleInfoFields = moduleInfo.querySelectorAll("div[data-module-type]");
    moduleInfoFields.forEach((field) => {
        if (field.dataset.moduleType === 'functional') {
            field.innerHTML = data.functional ? "Yes" : "No";
        } else {
            field.innerHTML = data[field.dataset.moduleType];
        }
    });
}
const getModuleHistory = async (moduleId) => {
    return await request(`/module/history/${moduleId}`, "GET");
};

const getModuleTypes = async () => {
    return await request(`/module/types`, "GET");
};

const getModuleInfo = async (moduleId) => {
    return await request(`/module/info/${moduleId}`, "GET");
}

const request = async (url, method = "GET", data = null) => {
    const response = await fetch(url, {
        method: method,
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: data != null ? JSON.stringify(data) : null,
    });
    const responseData = await response.json();
    return responseData;
};

const initPieChart = (data) => {
    // console.log(data);
    const ctx = document.getElementById("pieChart").getContext("2d");
    const labelColors = {
        lpwan: "#bcece0",
        cellular: "#36eee0",
        zigbee: "#f652a0",
        bluetooth: "#4c5270",
        wifi: "#F85C70",
        rfid: "#f8d210",
        other: "#FF6384",
    };
    const myChart = new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: data.map((item) => item.type),
            datasets: [
                {
                    label: "Number of modules by type",
                    backgroundColor: data.map((item) => labelColors[item.type]),
                    data: data.map((item) => item.count),
                },
            ],
        },
        options: {
            datasets: {
                doughnut: {},
            },
        },
    });
};

// const ctx = document.getElementById("myChart").getContext("2d");
// const myChart = new Chart(ctx, {
//     type: "bar",
//     data: {
//         labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
//         datasets: [
//             {
//                 label: "# of Votes",
//                 data: [12, 19, 3, 5, 2, 3],
//                 backgroundColor: [
//                     "rgba(255, 99, 132, 0.2)",
//                     "rgba(54, 162, 235, 0.2)",
//                     "rgba(255, 206, 86, 0.2)",
//                     "rgba(75, 192, 192, 0.2)",
//                     "rgba(153, 102, 255, 0.2)",
//                     "rgba(255, 159, 64, 0.2)",
//                 ],
//                 borderColor: [
//                     "rgba(255, 99, 132, 1)",
//                     "rgba(54, 162, 235, 1)",
//                     "rgba(255, 206, 86, 1)",
//                     "rgba(75, 192, 192, 1)",
//                     "rgba(153, 102, 255, 1)",
//                     "rgba(255, 159, 64, 1)",
//                 ],
//                 borderWidth: 1,
//             },
//         ],
//     },
//     options: {
//         scales: {
//             y: {
//                 beginAtZero: true,
//             },
//         },
//     },
// });

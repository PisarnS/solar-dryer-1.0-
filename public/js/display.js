// นาฬิกา
function updateDateTime() {
    const now = new Date(); // สร้างอ็อบเจกต์ Date เพื่อรับวันและเวลาปัจจุบัน

    // กำหนดรูปแบบวันที่ให้แสดงเป็นแบบภาษาไทย
    const dateOptions = {
        year: "numeric",
        month: "long",
        day: "numeric",
        weekday: "long",
    };
    const dateString = now.toLocaleDateString("th-TH", dateOptions); // แปลงวันที่เป็นข้อความตามรูปแบบไทย
    const timeString = now.toLocaleTimeString("th-TH", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
    }); // แปลงเวลาเป็นข้อความแบบ HH:MM:SS

    // แสดงผลวันที่และเวลาในหน้าเว็บ
    document.getElementById("current-date").textContent = dateString;
    document.getElementById("current-time").textContent = timeString;
}

// อัปเดตเวลาใหม่ทุก 1 วินาที
setInterval(updateDateTime, 1000);
updateDateTime(); // เรียกใช้ทันทีตอนโหลดหน้า



// ฟังก์ชันสำหรับดึงข้อมูลเซ็นเซอร์
async function fetchData(limit = 100) {
    try {
        const response = await fetch(`/get-esp32-data?limit=${limit}`); // เรียก API โดยส่งจำนวนข้อมูลที่ต้องการ
        const data = await response.json(); // แปลงผลลัพธ์เป็น JSON

        if (!Array.isArray(data) || data.length === 0) {
            console.log("❌ ไม่มีข้อมูลจากเซ็นเซอร์");
            return;
        }

        // เรียงข้อมูลตามเวลา (เก่าสุด -> ใหม่สุด)
        data.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));

        // สร้าง label สำหรับกราฟจากเวลา (ตัดวินาทีออก)
        const labels = data.map((item) =>
            new Date(item.created_at).toLocaleTimeString("th-TH", {
                hour: "2-digit",
                minute: "2-digit",
            })
        );

        // แยกข้อมูลแต่ละชนิดออกมา
        const temperatures = data.map((item) => item.temperature);
        const humidities = data.map((item) => item.humidity);
        const lightIntensities = data.map((item) => item.LightIntensity);
        const weights = data.map((item) => item.weight);

        // อัปเดตกราฟแต่ละตัว
        updateChart(tempChart, labels, temperatures);
        updateChart(humidityChart, labels, humidities);
        updateChart(lightChart, labels, lightIntensities);
        updateChart(weightChart, labels, weights);

        // อัปเดตรวมกราฟทั้งหมด
        updateAllStatusChart(
            labels,
            temperatures,
            humidities,
            lightIntensities,
            weights
        );
    } catch (error) {
        console.error("❌ เกิดข้อผิดพลาดในการโหลดข้อมูล:", error);
    }
}



// ฟังก์ชันอัปเดตกราฟ
function updateChart(chart, labels, data) {
    chart.data.labels = labels;         // อัปเดต label บนแกน X
    chart.data.datasets[0].data = data; // อัปเดตข้อมูลในชุดกราฟ
    chart.update();                     // สั่งให้กราฟรีเฟรชข้อมูล
}



// อัปเดตกราฟทั้งหมด
const updateAllStatusChart = (
    labels,
    temperatures,
    humidities,
    lightIntensities,
    weights
) => {
    allStatusChart.data.labels = labels;              // แกน X
    allStatusChart.data.datasets[0].data = temperatures;
    allStatusChart.data.datasets[1].data = humidities;
    allStatusChart.data.datasets[2].data = lightIntensities;
    allStatusChart.data.datasets[3].data = weights;
    allStatusChart.update();                          // รีเฟรชกราฟ
};



// ฟังก์ชันสร้างกราฟ
const createChart = (id, label, color) => {
    return new Chart(document.getElementById(id).getContext("2d"), {
        type: "line", // กราฟเส้น
        data: {
            labels: [], // เวลาบนแกน X
            datasets: [
                {
                    label,
                    data: [],
                    borderColor: color, // สีเส้น
                    fill: true,
                    tension: 0.3, // ความโค้งของเส้น
                    pointRadius: 1, // ขนาดจุด
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    title: { display: true, text: "เวลา" },
                    reverse: false, // กำหนดให้แกน x ไล่จากซ้ายไปขวา
                },
                y: {
                    title: { display: true, text: label },
                },
            },
        },
    });
};



// สร้างกราฟแต่ละตัว
const tempChart = createChart("tempChart", "อุณหภูมิ (°C)", "red");
const humidityChart = createChart("humidityChart", "ความชื้น (%)", "blue");
const lightChart = createChart("lightChart", "ความเข้มแสง", "yellow");
const weightChart = createChart("weightChart", "น้ำหนัก (g)", "cyan");

const allStatusChart = new Chart(
    document.getElementById("allStatusChart").getContext("2d"),
    {
        type: "line",
        data: {
            labels: [],  // ใส่ข้อมูลเวลา
            datasets: [
                {
                    label: "อุณหภูมิ (°C)",
                    data: [],
                    borderColor: "red",
                    // backgroundColor: "rgba(255, 0, 0, 0.2)",
                    // fill: true,
                    tension: 0.1,
                    yAxisID: "y-temp",
                },
                {
                    label: "ความชื้น (%)",
                    data: [],
                    borderColor: "blue",
                    // backgroundColor: "rgba(0, 0, 255, 0.2)",
                    // fill: true,
                    tension: 0.1,
                    yAxisID: "y-humidity",
                },
                {
                    label: "ความเข้มแสง (W/m2)",
                    data: [],
                    borderColor: "yellow",
                    // backgroundColor: "rgba(255, 255, 0, 0.2)",
                    // fill: true,
                    tension: 0.1,
                    yAxisID: "y-light",
                },
                {
                    label: "น้ำหนัก (g)",
                    data: [],
                    borderColor: "green",
                    // backgroundColor: "rgba(0, 255, 0, 0.2)",
                    // fill: true,
                    tension: 0.1,
                    yAxisID: "y-weight",
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    title: { display: true, text: "เวลา" },
                    ticks: { autoSkip: true, maxTicksLimit: 10 },
                },
                "y-temp": {
                    type: "linear",
                    position: "left",
                    title: { display: true, text: "อุณหภูมิ (°C)" },
                    min: 0,
                    max: 100,
                },
                "y-humidity": {
                    type: "linear",
                    position: "right",
                    title: { display: true, text: "ความชื้น (%)" },
                    min: 0,
                    max: 100,
                    grid: { drawOnChartArea: false },
                },
                "y-light": {
                    type: "logarithmic", // ใช้สเกล log เพราะค่าความเข้มแสงเปลี่ยนแปลงมาก
                    position: "left",
                    title: { display: true, text: "ความเข้มแสง (W/m2)" },
                    min: 1,
                    max: 100000,
                    grid: { drawOnChartArea: false },
                },
                "y-weight": {
                    type: "logarithmic", // ใช้สเกล log เช่นกัน
                    position: "right",
                    title: { display: true, text: "น้ำหนัก (g)" },
                    min: 0,
                    max: 2000,
                    grid: { drawOnChartArea: false },
                    ticks: {
                        callback: function (value) {
                            return value.toFixed(2) + " g"; // แสดงน้ำหนักเป็นทศนิยม
                        },
                    },
                },
            },
            plugins: {
                tooltip: {
                    mode: "index",
                    intersect: false,
                    callbacks: {
                        label: function (tooltipItem) {
                            let label = tooltipItem.dataset.label || "";
                            let value = tooltipItem.raw;
                            if (label.includes("น้ำหนัก")) {
                                return `${label}: ${value.toFixed(2)} g`;
                            }
                            return `${label}: ${value}`;
                        },
                    },
                },
                legend: {
                    position: "top",
                },
            },
        },
    }
);



// ฟังก์ชันเมื่อเปลี่ยนช่วงเวลา
document.getElementById("timeRange").addEventListener("change", function () {
    const selectedValue = this.value;
    console.log(`📡 ดึงข้อมูล ${selectedValue} ค่า`);
    fetchData(selectedValue); // ดึงข้อมูลใหม่ตามจำนวนที่เลือก
});



// อัปเดตข้อมูลทุก 5 วินาที (ค่าเริ่มต้นใช้ 100 ค่า)
setInterval(() => {
    const selectedValue = document.getElementById("timeRange").value || 100;
    fetchData(selectedValue);
}, 5000);



// โหลดข้อมูล 100 ค่าเริ่มต้นทันทีเมื่อเปิดหน้าเว็บ
fetchData(100);

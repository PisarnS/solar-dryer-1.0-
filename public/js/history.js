// รอให้ DOM โหลดเสร็จก่อนจึงเริ่มทำงาน
document.addEventListener("DOMContentLoaded", function () {
    // ดึงข้อมูลจากตัวแปร global ที่ประกาศไว้ก่อนหน้า (ต้องแน่ใจว่ามีการกำหนด window.historyData ไว้ใน HTML)
    const { labels, temperature, humidity, weight, light } = window.historyData;

    // ฟังก์ชันสำหรับสร้างกราฟ
    const createChart = (elementId, label, data, yAxisLabel, borderColor, backgroundColor) => {
        new Chart(document.getElementById(elementId).getContext('2d'), {
            type: 'line', // ประเภทกราฟ: เส้น (line)
            data: {
                labels: labels, // ค่าแกน X (เช่น เวลา)
                datasets: [{
                    label: label, // ชื่อกราฟที่แสดงใน legend
                    data: data, // ข้อมูลที่จะแสดงในกราฟ
                    borderColor: borderColor, // สีเส้นกราฟ
                    backgroundColor: backgroundColor, // สีพื้นหลังใต้เส้นกราฟ
                    tension: 0.3, // ความโค้งของเส้นกราฟ
                    fill: true, // เติมพื้นใต้เส้นกราฟ
                    pointRadius: 1, // ขนาดจุดข้อมูล
                }]
            },
            options: {
                responsive: true, // ปรับขนาดอัตโนมัติตามหน้าจอ
                plugins: {
                    legend: {
                        display: true, // แสดงคำอธิบายชุดข้อมูล
                        position: 'top' // ตำแหน่ง legend ด้านบน
                    }
                },
                scales: {
                    y: {
                        title: {
                            display: true,
                            text: yAxisLabel // ป้ายกำกับแกน Y
                        },
                        beginAtZero: false // ไม่เริ่มจาก 0 เพื่อให้ข้อมูลชัดเจนขึ้น (เปลี่ยนเป็น true หากต้องการ)
                    }
                }
            }
        });
    };

    // สร้างกราฟทั้งหมด พร้อมกำหนดสี
    createChart('weightChart', 'น้ำหนัก (g)', weight, 'น้ำหนัก (g)', 'rgb(76, 210, 255)', 'rgba(0, 191, 255, 0.2)'); // สีฟ้า
    createChart('tempChart', 'อุณหภูมิ (°C)', temperature, 'อุณหภูมิ (°C)', 'rgba(255, 99, 132, 1)', 'rgba(255, 99, 132, 0.2)'); // สีแดง
    createChart('humidityChart', 'ความชื้น (%)', humidity, 'ความชื้น (%)', 'rgb(18, 46, 202)', 'rgba(54, 162, 235, 0.2)'); // สีน้ำเงิน
    createChart('lightChart', 'แสง (W/m2)', light, 'แสง (W/m2)', 'rgba(255, 206, 86, 1)', 'rgba(255, 206, 86, 0.2)'); // สีเหลือง
});

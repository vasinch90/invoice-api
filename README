Invoice & Payment API — ภาพรวม

===========================================================================
เป็น REST API สำหรับธุรกิจ SME ที่ต้องการระบบออกใบแจ้งหนี้และรับชำระเงินออนไลน์ ลูกค้าบน Fiverr ต้องการแบบนี้เยอะมากครับ เพราะสร้างเองไม่เป็น แต่จ่ายได้

===========================================================================
Features หลัก:
    - ออกใบแจ้งหนี้ (Invoice) พร้อม PDF export
    - รับชำระเงินผ่าน Omise (สำหรับลูกค้าไทย) หรือ Stripe (ต่างประเทศ)
    - Webhook รับสถานะการชำระเงิน
    - JWT Authentication สำหรับ multi-user
    - Dashboard สรุปยอด

===========================================================================
โครงสร้าง API Endpoints:
    - POST   /api/auth/login
    - POST   /api/auth/register

    - GET    /api/invoices          → ดูรายการทั้งหมด
    - POST   /api/invoices          → สร้างใบแจ้งหนี้
    - GET    /api/invoices/:id      → ดูรายละเอียด
    - GET    /api/invoices/:id/pdf  → export PDF
    - DELETE /api/invoices/:id      → ลบ

    - POST   /api/payments/charge   → สร้าง payment
    - POST   /api/webhooks/omise    → รับ webhook จาก Omise
    - POST   /api/webhooks/stripe   → รับ webhook จาก Stripe

    - GET    /api/dashboard/summary → ยอดรวม, paid/unpaid
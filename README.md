# D.P. Chaturvedi College (DPCC) — Institutional ERP System

A comprehensive, production-ready Higher-Education Institutional ERP system customized for **D.P. Chaturvedi College (DPCC)**, Seoni, Madhya Pradesh (Affiliated to Raja Shankar Shah University, Chhindwara, Institution Code: **JS-499**).

Built on **Laravel 13**, **Tailwind CSS**, and **Vite**, fully compliant with **NEP 2020**, **NCTE**, **AISHE**, and **NAAC** regulatory frameworks.

---

## 🏛️ Institutional Profile

* **Institution:** D.P. Chaturvedi College (DPCC)
* **Code:** JS-499
* **Affiliation:** Raja Shankar Shah University, Chhindwara (formerly RDVV)
* **Accreditation:** NAAC-Accredited Institution & NCTE Recognized
* **Legacy:** Established in 2000 (Over 25 years of academic legacy)
* **Location:** PWD Colony, Barapathar, Seoni, Madhya Pradesh – 480661
* **Campus:** 2-Acre Green Eco-Campus
* **Founder & Chairman:** Dr. K.K. Chaturvedi
* **Principal:** Dr. Amita Chaturvedi (M.Sc., M.Ed., Ph.D.)
* **Helpline:** 07692-226635 | **Email:** dpccollegeseoni@gmail.com | **Web:** [www.dpccollege.com](https://www.dpccollege.com/)

---

## 🚀 Key Modules (All 30 Included)

1. **Dashboard & Analytics**: Real-time stats on students, faculty workload, admissions, fee collections, library overdues, and Chart.js analytics.
2. **Online Admission Management**: Public admission portal, merit list cut-off computation, registration numbering, and online receipts.
3. **Enquiry & Admission CRM**: Walk-in and lead tracking, counsellor assignment, follow-up calendar, and communication.
4. **Student Information System (SIS)**: 360° student records, category & reservation details, guardians, and digital Student ID Cards.
5. **Course & Academic Management (NEP 2020)**: B.Sc., M.Sc., B.Com., M.Com., B.A., M.S.W., B.Ed., and D.El.Ed. programs.
6. **Class & Timetable Management**: Section allocations, classroom scheduling, and conflict detection.
7. **Attendance Management**: Student and staff attendance recording, daily percentage metrics, and shortage tracking.
8. **Examination Management**: Continuous Comprehensive Evaluation (CCE), Mid-Term & End-Term university exams, admit cards, and marksheets.
9. **Library Management**: 15,000+ volume catalogue, accession numbers, barcodes, and automated overdue tracking.
10. **Fee & Student Accounts**: Course-wise fee structures, installment tracking, and instant fee receipts.
11. **College Finance & Accounting**: Chart of Accounts, General Ledger, Cashbook, vouchers, and departmental budgets.
12. **Faculty & Staff HR**: Employee profiles, service records, qualifications, workload, and leave management.
13. **Payroll Management**: Indian salary structures (Basic, HRA, DA, TA, PF, Professional Tax, TDS) and automated monthly payslips.
14. **Hostel Management**: Vivekananda Boys Hostel and Sarojini Devi Girls Hostel room allocations, mess fees, and gate passes.
15. **Transport Management**: College bus fleet covering Seoni town, Lakhnadon, Chhapara, Barghat, Keolari, and Kurai tehsils.
16. **Procurement & Inventory**: Purchase requisitions, Purchase Orders (PO), and lab equipment inventory.
17. **Student Portal**: Student self-service dashboard, weekly timetable, marksheet download, and assignments.
18. **Faculty Portal**: Faculty teaching schedules, attendance marking, grade entry, and leave applications.
19. **Parent Portal**: Multi-child linking, attendance tracking, fee balances, and exam results.
20. **Learning Management System (LMS)**: Lecture notes, assignments, student submissions, and subject discussion forums.
21. **Placement & Career Cell**: Corporate placement drives, job openings, and student application tracking.
22. **Scholarships & Financial Aid**: MP Post-Matric SC/ST/OBC scholarship workflows and institutional merit awards.
23. **Certificates & Document Management**: Digital Bonafide, Transfer (TC), and Migration certificates with instant verification tokens.
24. **Grievance & Discipline**: Confidential anti-ragging, academic grievances, and disciplinary redressal.
25. **Campus Events & Clubs**: Annual fest, science exhibition, sports meets, and event budgets.
26. **Alumni Association**: Batch directory, alumni mentorship, and contribution registry.
27. **Accreditation & Compliance**: NAAC SSR metrics, NCTE inspection registers, and AISHE data tracking.
28. **Research & Innovation**: Faculty publications, research grants (DST-SERB / State Biodiversity Board), and projects.
29. **Communication & Alerts**: College-wide notices, WhatsApp alerts, and emergency circulars.
30. **System Administration & RBAC**: Role-based access control (Admin, Faculty, Student, Parent, Accountant, Librarian) and audit logs.

---

## 🛠️ Tech Stack

- **Backend**: Laravel 13 (PHP 8.4+)
- **Database**: SQLite / MySQL
- **Frontend**: Blade templates, Tailwind CSS, Vite
- **Testing**: PHPUnit Feature Test Suite

---

## ⚙️ Quick Start

```bash
# 1. Install dependencies
composer install
npm install

# 2. Environment setup
cp .env.example .env
php artisan key:generate
php artisan migrate --seed

# 3. Start development servers
php artisan serve
npm run dev
```

---

## 🔒 Pre-Seeded Demo Credentials

**Default Password for all accounts:** `password`

* **Principal / Super Admin**: `admin@dpccollege.com`
* **Faculty (Science & Education)**: `faculty@dpccollege.com`
* **Student (B.Sc. Maths)**: `student@dpccollege.com`
* **Parent**: `parent@dpccollege.com`

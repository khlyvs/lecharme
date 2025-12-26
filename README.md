# LeCharme E-Commerce Platform

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

<p align="center">
  <strong>Modern e-commerce platform built with Laravel</strong>
</p>

---

## 📋 Məzmun

- [Layihə Haqqında](#layihə-haqqında)
- [Texnologiyalar](#texnologiyalar)
- [Arxitektura](#arxitektura)
- [Filter API](#filter-api)
- [Quraşdırma](#quraşdırma)
- [İstifadə](#istifadə)

---

## 🎯 Layihə Haqqında

**LeCharme** - Multi-language e-commerce platform. Məhsul kataloqu, filter sistemi, səbət və favoritlər funksionallığı ilə tam funksional e-ticarət saytı.

### Xüsusiyyətlər

- ✅ **Multi-language** (Azərbaycan, English, Русский)
- ✅ **Real-time Filtering** - Debounced və instant filterlər
- ✅ **Optimized Queries** - Cache, eager loading, indexes
- ✅ **AJAX Support** - Səhifə yenilənmədən filterleme
- ✅ **Responsive Design** - Mobile-friendly
- ✅ **Clean Architecture** - Repository Pattern, Service Layer

---

## 🛠 Texnologiyalar

- **Backend:** Laravel 11.x
- **Frontend:** Vanilla JavaScript, CSS3
- **Database:** MySQL
- **Cache:** Redis/File Cache
- **Validation:** FormRequest classes

---

## 🏗 Arxitektura

```
Controller → Service → Repository → Model
     ↓         ↓          ↓          ↓
   Request  Business   Database   Eloquent
            Logic      Queries    ORM
```

### Struktur

```
app/
├── Http/
│   ├── Controllers/
│   │   └── website/
│   │       └── Category/
│   │           └── CategoryController.php
│   └── Requests/
│       └── FilterRequest.php
├── Services/
│   └── Website/
│       └── Filter/
│           └── FilterProductService.php
├── Repositories/
│   └── Website/
│       └── Filter/
│           └── FilterProductRepository.php
└── Interfaces/
    └── Website/
        └── Filter/
            └── FilterProductRepositoryInterface.php
```

---

## 🔍 Filter API

Tam API dokumentasiyası: **[docs/FILTER_API.md](docs/FILTER_API.md)**

### Quick Start

**Endpoint:**
```
GET /{locale}/category/{categorySlug}
GET /{locale}/category/{categorySlug}/{subcategorySlug}
```

**Filter Parametrləri:**
- `min_price` - Minimum qiymət
- `max_price` - Maksimum qiymət
- `subcategories[]` - Alt kateqoriya ID-ləri
- `has_discount` - Endirimli məhsullar
- `sort` - Sıralama (default, price-low, price-high, newest)
- `page` - Səhifə nömrəsi
- `per_page` - Səhifədə məhsul sayı

**Nümunə:**
```
GET /az/category/geyim?min_price=50&max_price=200&sort=price-low&has_discount=1
```

---

## ⚙️ Quraşdırma

### Tələblər

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js & NPM (frontend assets üçün)

### Addımlar

1. **Repository klonla:**
```bash
git clone https://github.com/your-repo/LeCharme.git
cd LeCharme
```

2. **Dependencies quraşdır:**
```bash
composer install
npm install
```

3. **Environment konfiqurasiyası:**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database:**
```bash
php artisan migrate
php artisan db:seed
```

5. **Assets build et:**
```bash
npm run build
```

6. **Cache təmizlə:**
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## 📖 İstifadə

### Development Server

```bash
php artisan serve
```

### Frontend Assets Watch

```bash
npm run dev
```

---

## 📚 Dokumentasiya

- **[Filter API Documentation](docs/FILTER_API.md)** - Tam API dokumentasiyası
- **[Laravel Documentation](https://laravel.com/docs)**

---

## 🧪 Testing

```bash
php artisan test
```

---

## 📝 License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 👥 Contributors

- Development Team

---

## 🔗 Links

- [Laravel Documentation](https://laravel.com/docs)
- [Filter API Docs](docs/FILTER_API.md)

---

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

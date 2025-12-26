# Filter API Documentation

## 📋 Məzmun

- [Ümumi Məlumat](#ümumi-məlumat)
- [API Endpoints](#api-endpoints)
- [Filter Parametrləri](#filter-parametrləri)
- [Request Validation](#request-validation)
- [Response Format](#response-format)
- [Nümunələr](#nümunələr)
- [Error Handling](#error-handling)

---

## Ümumi Məlumat

Filter API, məhsulları müxtəlif kriteriyalara görə filtrələmək üçün istifadə olunur. Sistem real-time filtering dəstəkləyir və AJAX ilə işləyir.

### Base URL
```
/{locale}/category/{categorySlug}
/{locale}/category/{categorySlug}/{subcategorySlug}
```

### Locale Dəyərləri
- `az` - Azərbaycan
- `en` - English
- `ru` - Русский

---

## API Endpoints

### 1. Category Page (Kateqoriya Səhifəsi)

**Endpoint:**
```
GET /{locale}/category/{categorySlug}
```

**Parametrlər:**
- `locale` (required) - Dil kodu
- `categorySlug` (required) - Kateqoriya slug

**Query Parametrləri:**
Bax: [Filter Parametrləri](#filter-parametrləri)

**Nümunə:**
```
GET /az/category/geyim?min_price=50&max_price=200&sort=price-low
```

---

### 2. Subcategory Page (Alt Kateqoriya Səhifəsi)

**Endpoint:**
```
GET /{locale}/category/{categorySlug}/{subcategorySlug}
```

**Parametrlər:**
- `locale` (required) - Dil kodu
- `categorySlug` (required) - Ana kateqoriya slug
- `subcategorySlug` (required) - Alt kateqoriya slug

**Query Parametrləri:**
Bax: [Filter Parametrləri](#filter-parametrləri)

**Nümunə:**
```
GET /az/category/geyim/kofta?has_discount=1&sort=newest
```

---

## Filter Parametrləri

### Qiymət Aralığı (Price Range)

| Parametr | Tip | Təsvir | Validation |
|----------|-----|--------|------------|
| `min_price` | float | Minimum qiymət | `nullable`, `numeric`, `min:0`, `max:999999` |
| `max_price` | float | Maksimum qiymət | `nullable`, `numeric`, `min:0`, `max:999999`, `gte:min_price` |

**Nümunə:**
```
?min_price=50&max_price=200
```

**Qeyd:** `max_price` həmişə `min_price`-dən böyük və ya bərabər olmalıdır.

---

### Alt Kateqoriyalar (Subcategories)

| Parametr | Tip | Təsvir | Validation |
|----------|-----|--------|------------|
| `subcategories[]` | array | Alt kateqoriya ID-ləri | `nullable`, `array`, `subcategories.*` → `exists:subcategories,id` |

**Nümunə:**
```
?subcategories[]=1&subcategories[]=2&subcategories[]=3
```

**Qeyd:** Yalnız kateqoriya səhifəsində işləyir (subcategory səhifəsində yox).

---

### Endirimli Məhsullar (Discounted Products)

| Parametr | Tip | Təsvir | Validation |
|----------|-----|--------|------------|
| `has_discount` | boolean | Endirimli məhsullar | `nullable`, `boolean` |

**Nümunə:**
```
?has_discount=1
?has_discount=true
```

---

### Sıralama (Sorting)

| Parametr | Tip | Təsvir | Validation |
|----------|-----|--------|------------|
| `sort` | string | Sıralama növü | `nullable`, `in:default,price-low,price-high,newest` |

**Dəyərlər:**
- `default` - Varsayılan (ID-yə görə azalan)
- `price-low` - Qiymət: aşağıdan yuxarı
- `price-high` - Qiymət: yuxarıdan aşağı
- `newest` - Ən yeni (yaradılma tarixinə görə)

**Nümunə:**
```
?sort=price-low
```

---

### Pagination (Səhifələmə)

| Parametr | Tip | Təsvir | Validation |
|----------|-----|--------|------------|
| `page` | integer | Səhifə nömrəsi | `nullable`, `integer`, `min:1` |
| `per_page` | integer | Səhifədə məhsul sayı | `nullable`, `integer`, `min:1`, `max:100` |

**Nümunə:**
```
?page=2&per_page=24
```

**Default:** `per_page = 12`

---

## Request Validation

Bütün filter parametrləri `FilterRequest` class-ı ilə validasiya olunur.

### Validation Rules

```php
[
    'min_price' => 'nullable|numeric|min:0|max:999999',
    'max_price' => 'nullable|numeric|min:0|max:999999|gte:min_price',
    'subcategories' => 'nullable|array',
    'subcategories.*' => 'required|integer|exists:subcategories,id',
    'has_discount' => 'nullable|boolean',
    'sort' => 'nullable|string|in:default,price-low,price-high,newest',
    'page' => 'nullable|integer|min:1',
    'per_page' => 'nullable|integer|min:1|max:100',
]
```

### Validation Error Messages

| Field | Error Message |
|-------|---------------|
| `min_price.numeric` | Minimum qiymət rəqəm olmalıdır |
| `max_price.gte` | Maksimum qiymət minimum qiymətdən böyük və ya bərabər olmalıdır |
| `subcategories.*.exists` | Seçilmiş alt kateqoriya mövcud deyil |
| `sort.in` | Sıralama seçimi düzgün deyil |

---

## Response Format

### Regular Request (HTML)

**Status Code:** `200 OK`

**Response:**
```html
<!-- Full HTML page with products -->
```

### AJAX Request (JSON)

**Headers:**
```
X-Requested-With: XMLHttpRequest
Accept: application/json
```

**Status Code:** `200 OK`

**Response:**
```json
{
    "html": "<article>...</article>",
    "count": 42,
    "pagination": "<nav>...</nav>"
}
```

**Response Fields:**
- `html` (string) - Məhsul kartlarının HTML kodu
- `count` (integer) - Tapılan məhsul sayı
- `pagination` (string) - Pagination HTML kodu

---

## Nümunələr

### Nümunə 1: Qiymət Aralığı ilə Filter

**Request:**
```
GET /az/category/geyim?min_price=50&max_price=200
```

**Response:**
```json
{
    "html": "...",
    "count": 15,
    "pagination": "..."
}
```

---

### Nümunə 2: Çoxlu Filterlər

**Request:**
```
GET /az/category/geyim?min_price=100&max_price=500&has_discount=1&sort=price-low&subcategories[]=5&subcategories[]=7
```

**Təsvir:**
- Minimum qiymət: 100 AZN
- Maksimum qiymət: 500 AZN
- Yalnız endirimli məhsullar
- Qiymətə görə artan sıralama
- Alt kateqoriya ID-ləri: 5, 7

---

### Nümunə 3: AJAX Request (JavaScript)

```javascript
const url = new URL('/az/category/geyim', window.location.origin);
url.searchParams.set('min_price', 50);
url.searchParams.set('max_price', 200);
url.searchParams.set('sort', 'price-low');

fetch(url.toString(), {
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json',
    },
})
.then(response => response.json())
.then(data => {
    document.getElementById('products-grid').innerHTML = data.html;
    document.getElementById('results-count').textContent = `${data.count} məhsul tapıldı`;
});
```

---

## Error Handling

### Validation Errors

**Status Code:** `422 Unprocessable Entity`

**Response:**
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "max_price": [
            "Maksimum qiymət minimum qiymətdən böyük və ya bərabər olmalıdır"
        ],
        "subcategories.0": [
            "Seçilmiş alt kateqoriya mövcud deyil"
        ]
    }
}
```

---

### Not Found (404)

**Status Code:** `404 Not Found`

**Səbəblər:**
- Kateqoriya tapılmadı
- Alt kateqoriya tapılmadı
- Slug düzgün deyil

---

### Server Error (500)

**Status Code:** `500 Internal Server Error`

**Response:**
```json
{
    "message": "Server error occurred"
}
```

---

## Performance Tips

### 1. Cache İstifadəsi
- Subcategory ID-lər cache-də saxlanılır (1 saat)
- Cache key: `subcategory.id.{slug}`

### 2. Query Optimization
- Yalnız lazımi sütunlar seçilir
- Eager loading istifadə olunur (`mainImage`, `category`)
- Database index-ləri mövcuddur

### 3. Frontend Optimization
- Debouncing (400ms) - qiymət inputları üçün
- Request cancellation - yeni request gəldikdə köhnə ləğv olunur
- Loading states - minimum 300ms

---

## Frontend Integration

### Real-time Filtering

Filter sistemi real-time işləyir:
- Qiymət inputları: 400ms debounce
- Checkbox/Select: Instant
- Badge buttons: Instant

### JavaScript API

```javascript
// Filter URL yaratmaq
const filters = {
    min_price: 50,
    max_price: 200,
    sort: 'price-low',
    has_discount: true,
};

const url = buildFilterUrl('/az/category/geyim', filters);

// AJAX request
loadProducts(filters);
```

---

## Changelog

### v1.0.0 (2024-12-26)
- ✅ FilterRequest validation əlavə edildi
- ✅ Real-time filtering
- ✅ AJAX dəstəyi
- ✅ Error handling
- ✅ Documentation

---

## Support

Suallar və problemlər üçün:
- Email: support@lecharme.az
- Documentation: `/docs/FILTER_API.md`

---

**Son yeniləmə:** 2024-12-26


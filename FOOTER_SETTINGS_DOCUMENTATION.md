# Footer Settings Documentation

## Overview
Fitur Footer Settings memungkinkan administrator untuk mengedit konten footer di halaman public website sekolah melalui panel admin. Fitur ini mencakup pengaturan deskripsi footer, link media sosial, dan informasi kontak.

## Features

### 1. Footer Content Management
- **Footer Description**: Deskripsi sekolah yang ditampilkan di footer
- **Social Media Links**: Link ke akun media sosial sekolah (Facebook, Instagram, YouTube, Twitter)
- **Contact Information**: Alamat, nomor telepon, dan email sekolah

### 2. Dynamic Footer Display
- Footer secara otomatis menggunakan data dari settings
- Jika link media sosial kosong, tidak akan ditampilkan
- Fallback ke nilai default jika settings belum dikonfigurasi

## Implementation Details

### 1. Database Structure
Footer settings disimpan dalam tabel `settings` dengan group `footer`:

```sql
-- Footer settings keys:
- footer_description (string)
- footer_facebook (url)
- footer_instagram (url)
- footer_youtube (url)
- footer_twitter (url)
- footer_address (string)
- footer_phone (string)
- footer_email (email)
```

### 2. Controller Updates
File: `app/Http/Controllers/Admin/SettingController.php`

**Added:**
- Validation rules untuk footer fields
- Footer group dalam `getSettingGroup()` method
- Default values untuk footer settings dalam `reset()` method

### 3. View Updates

#### Admin Settings Page
File: `resources/views/admin/settings/index.blade.php`

**Added:**
- Tab "Footer" dengan icon globe
- 3 cards untuk footer settings:
  1. **Footer Content Card**: Textarea untuk deskripsi footer
  2. **Social Media Links Card**: Input URL untuk 4 platform media sosial
  3. **Contact Information Card**: Input untuk alamat, telepon, dan email

#### Public Layout Footer
File: `resources/views/layouts/public.blade.php`

**Updated:**
- Footer description menggunakan `footer_description` setting
- Social media links hanya ditampilkan jika URL dikonfigurasi
- Contact information menggunakan settings dengan fallback
- Link footer mengarah ke route yang benar

### 4. Migration
File: `database/migrations/2024_01_01_000001_add_footer_settings_to_settings_table.php`

**Purpose:**
- Menambahkan default footer settings ke database
- Menggunakan nilai default yang sesuai
- Dapat di-rollback dengan aman

## Usage Instructions

### For Administrators

1. **Akses Footer Settings:**
   - Login ke admin panel
   - Navigasi ke Settings
   - Klik tab "Footer"

2. **Edit Footer Content:**
   - **Footer Description**: Masukkan deskripsi sekolah yang akan ditampilkan di footer
   - **Social Media Links**: Masukkan URL lengkap untuk setiap platform (opsional)
   - **Contact Information**: Update alamat, telepon, dan email sekolah

3. **Save Changes:**
   - Klik tombol "Save Settings"
   - Perubahan akan langsung terlihat di website public

### For Developers

#### Getting Footer Settings
```php
// Get footer description
$description = \App\Models\Setting::get('footer_description', 'Default description');

// Get social media URLs
$facebook = \App\Models\Setting::get('footer_facebook');
$instagram = \App\Models\Setting::get('footer_instagram');

// Get contact info
$address = \App\Models\Setting::get('footer_address');
$phone = \App\Models\Setting::get('footer_phone');
$email = \App\Models\Setting::get('footer_email');
```

#### Setting Footer Values Programmatically
```php
// Set footer description
\App\Models\Setting::set('footer_description', 'New description', 'string', 'footer');

// Set social media URL
\App\Models\Setting::set('footer_facebook', 'https://facebook.com/school', 'url', 'footer');
```

## Validation Rules

### Footer Description
- Type: `string`
- Max length: `500` characters
- Required: `No` (nullable)

### Social Media URLs
- Type: `url`
- Max length: `255` characters
- Required: `No` (nullable)
- Validation: Must be valid URL format

### Contact Information
- **Address**: `string`, max 500 characters
- **Phone**: `string`, max 50 characters  
- **Email**: `email`, max 255 characters

## Security Considerations

1. **URL Validation**: Semua URL media sosial divalidasi untuk memastikan format yang benar
2. **XSS Protection**: Output di-escape menggunakan `{{ }}` atau `{!! nl2br(e()) !!}`
3. **Input Sanitization**: Semua input melalui validasi Laravel
4. **External Links**: Link media sosial menggunakan `target="_blank"` dan `rel="noopener"`

## Styling & UI

### Admin Interface
- Menggunakan card-based layout yang konsisten
- Icon yang sesuai untuk setiap section
- Form validation dengan error messages
- Responsive design untuk mobile

### Public Footer
- Conditional rendering untuk social media links
- Proper spacing dan typography
- Responsive grid layout
- Accessible links dengan proper aria-labels

## Testing

### Manual Testing Checklist
- [ ] Footer settings dapat disimpan dan diupdate
- [ ] Validasi URL bekerja dengan benar
- [ ] Footer public menampilkan data yang benar
- [ ] Social media links hanya muncul jika dikonfigurasi
- [ ] Email link berfungsi dengan `mailto:`
- [ ] Responsive design bekerja di mobile
- [ ] Reset to default berfungsi

### Test Cases
```php
// Test footer description update
$this->post('/admin/settings', [
    'footer_description' => 'New school description'
]);

// Test social media URL validation
$this->post('/admin/settings', [
    'footer_facebook' => 'invalid-url'
])->assertSessionHasErrors('footer_facebook');

// Test valid social media URL
$this->post('/admin/settings', [
    'footer_facebook' => 'https://facebook.com/school'
])->assertSessionHasNoErrors();
```

## Future Enhancements

### Possible Improvements
1. **Additional Social Platforms**: LinkedIn, TikTok, WhatsApp
2. **Footer Logo**: Option to add school logo in footer
3. **Multiple Languages**: Multi-language footer support
4. **Footer Sections**: Customizable footer sections/columns
5. **Footer Menu**: Dynamic footer menu management
6. **Analytics**: Track footer link clicks

### Technical Improvements
1. **Caching**: Implement footer settings caching
2. **API**: REST API for footer settings management
3. **Bulk Operations**: Import/export footer settings
4. **Version Control**: Track footer settings changes
5. **Preview**: Live preview of footer changes

## Troubleshooting

### Common Issues

1. **Settings Not Saving**
   - Check validation errors
   - Verify database connection
   - Check file permissions

2. **Footer Not Updating**
   - Clear application cache
   - Check if settings are cached
   - Verify view cache is cleared

3. **Social Links Not Working**
   - Ensure URLs include `http://` or `https://`
   - Check URL validation rules
   - Verify target="_blank" is working

### Debug Commands
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Check footer settings in database
php artisan tinker
>>> \App\Models\Setting::where('group', 'footer')->get();

# Reset footer settings to default
php artisan migrate:rollback --step=1
php artisan migrate
```

## Conclusion

Footer Settings feature memberikan kontrol penuh kepada administrator untuk mengelola konten footer website sekolah. Implementasi ini mengikuti best practices Laravel dan menyediakan interface yang user-friendly untuk pengelolaan konten footer yang dinamis dan responsif.
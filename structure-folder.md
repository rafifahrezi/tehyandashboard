# File Tree: tehyandashboard

**Generated:** 2/5/2026, 3:34:53 PM
**Root Path:** `d:\tehyandashboard`

```
├── 📁 app
│   ├── 📁 Http
│   │   ├── 📁 Controllers
│   │   │   ├── 📁 Auth
│   │   │   │   ├── 🐘 AuthenticatedSessionController.php
│   │   │   │   ├── 🐘 ConfirmablePasswordController.php
│   │   │   │   ├── 🐘 EmailVerificationNotificationController.php
│   │   │   │   ├── 🐘 EmailVerificationPromptController.php
│   │   │   │   ├── 🐘 NewPasswordController.php
│   │   │   │   ├── 🐘 PasswordController.php
│   │   │   │   ├── 🐘 PasswordResetLinkController.php
│   │   │   │   ├── 🐘 RegisteredUserController.php
│   │   │   │   └── 🐘 VerifyEmailController.php
│   │   │   ├── 🐘 BahanController.php
│   │   │   ├── 🐘 CategoryController.php
│   │   │   ├── 🐘 Controller.php
│   │   │   ├── 🐘 DashboardController.php
│   │   │   ├── 🐘 ManajemenUserController.php
│   │   │   ├── 🐘 ProfileController.php
│   │   │   ├── 🐘 ReportController.php
│   │   │   └── 🐘 TransaksiStokController.php
│   │   └── 📁 Requests
│   │       ├── 📁 Auth
│   │       │   └── 🐘 LoginRequest.php
│   │       ├── 🐘 ProfileUpdateRequest.php
│   │       ├── 🐘 StockMoveRequest.php
│   │       └── 🐘 StoreUserRequest.php
│   ├── 📁 Listeners
│   │   └── 🐘 DetachUserRolesBeforeDelete.php
│   ├── 📁 Models
│   │   ├── 🐘 Bahan.php
│   │   ├── 🐘 Category.php
│   │   ├── 🐘 Report.php
│   │   ├── 🐘 StockMove.php
│   │   ├── 🐘 Test.php
│   │   └── 🐘 User.php
│   ├── 📁 Policies
│   │   └── 🐘 UserPolicy.php
│   ├── 📁 Providers
│   │   ├── 🐘 AppServiceProvider.php
│   │   └── 🐘 ViewServiceProvider.php
│   ├── 📁 Services
│   │   └── 🐘 StockService.php
│   └── 📁 View
│       └── 📁 Components
│           ├── 🐘 AppLayout.php
│           └── 🐘 GuestLayout.php
├── 📁 bootstrap
│   ├── 🐘 app.php
│   └── 🐘 providers.php
├── 📁 config
│   ├── 🐘 app.php
│   ├── 🐘 auth.php
│   ├── 🐘 cache.php
│   ├── 🐘 database.php
│   ├── 🐘 dompdf.php
│   ├── 🐘 filesystems.php
│   ├── 🐘 logging.php
│   ├── 🐘 mail.php
│   ├── 🐘 permission.php
│   ├── 🐘 queue.php
│   ├── 🐘 services.php
│   └── 🐘 session.php
├── 📁 database
│   ├── 📁 factories
│   │   └── 🐘 UserFactory.php
│   ├── 📁 migrations
│   │   ├── 🐘 0001_01_01_000000_create_users_table.php
│   │   ├── 🐘 0001_01_01_000001_create_cache_table.php
│   │   ├── 🐘 0001_01_01_000002_create_jobs_table.php
│   │   ├── 🐘 2025_10_19_085440_create_permission_tables.php
│   │   ├── 🐘 2025_10_23_093104_create_categories_table.php
│   │   ├── 🐘 2025_12_05_121808_create_bahans_table.php
│   │   ├── 🐘 2025_12_05_121920_create_stock_moves_table.php
│   │   ├── 🐘 2025_12_13_033809_update_status_and_is_active_on_bahans_table.php
│   │   ├── 🐘 2025_12_13_034841_alter_modify_is_active.php
│   │   ├── 🐘 2025_12_20_202849_add_telp_and_jabatan_to_users_table.php
│   │   └── 🐘 2026_01_05_012815_create_reports_table.php
│   ├── 📁 seeders
│   │   ├── 🐘 BahanSeeder.php
│   │   ├── 🐘 CategorySeeder.php
│   │   ├── 🐘 DatabaseSeeder.php
│   │   ├── 🐘 RolePermissionSeeder.php
│   │   └── 🐘 StockMoveSeeder.php
│   └── ⚙️ .gitignore
├── 📁 public
│   ├── ⚙️ .htaccess
│   ├── 📄 favicon.ico
│   ├── 🐘 index.php
│   └── 📄 robots.txt
├── 📁 resources
│   ├── 📁 css
│   │   └── 🎨 app.css
│   ├── 📁 js
│   │   ├── 📄 app.js
│   │   └── 📄 bootstrap.js
│   └── 📁 views
│       ├── 📁 admin
│       │   ├── 📁 bahan-baku
│       │   │   ├── 🐘 create.blade.php
│       │   │   ├── 🐘 edit.blade.php
│       │   │   └── 🐘 index.blade.php
│       │   ├── 📁 dashboard
│       │   │   └── 🐘 index.blade.php
│       │   ├── 📁 manajemen-user
│       │   │   ├── 🐘 create.blade.php
│       │   │   ├── 🐘 edit.blade.php
│       │   │   └── 🐘 index.blade.php
│       │   └── 📁 transaksi-stok
│       │       ├── 📁 partials
│       │       │   └── 🐘 transactions.blade.php
│       │       ├── 🐘 create.blade.php
│       │       ├── 🐘 index.blade copy.php
│       │       └── 🐘 index.blade.php
│       ├── 📁 auth
│       │   ├── 🐘 confirm-password.blade.php
│       │   ├── 🐘 forgot-password.blade.php
│       │   ├── 🐘 login.blade.php
│       │   ├── 🐘 register.blade.php
│       │   ├── 🐘 reset-password.blade.php
│       │   └── 🐘 verify-email.blade.php
│       ├── 📁 components
│       │   ├── 🐘 application-logo.blade.php
│       │   ├── 🐘 auth-session-status.blade.php
│       │   ├── 🐘 confirm-modal.blade copy.php
│       │   ├── 🐘 confirm-modal.blade.php
│       │   ├── 🐘 danger-button.blade.php
│       │   ├── 🐘 dropdown-link.blade.php
│       │   ├── 🐘 dropdown.blade.php
│       │   ├── 🐘 input-error.blade.php
│       │   ├── 🐘 input-label.blade.php
│       │   ├── 🐘 modal.blade.php
│       │   ├── 🐘 nav-link.blade.php
│       │   ├── 🐘 primary-button.blade.php
│       │   ├── 🐘 responsive-nav-link.blade.php
│       │   ├── 🐘 secondary-button.blade.php
│       │   ├── 🐘 snackbar-notification.blade.php
│       │   ├── 🐘 text-input.blade.php
│       │   └── 🐘 toast.blade.php
│       ├── 📁 layouts
│       │   ├── 🐘 app.blade.php
│       │   ├── 🐘 guest.blade.php
│       │   ├── 🐘 master.blade.php
│       │   └── 🐘 navigation.blade.php
│       ├── 📁 owner
│       │   ├── 📁 dashboard
│       │   │   └── 🐘 index.blade.php
│       │   ├── 📁 laporan
│       │   │   ├── 🐘 create.blade.php
│       │   │   ├── 🐘 edit.blade.php
│       │   │   ├── 🐘 index.blade.php
│       │   │   ├── 🐘 print-list.blade.php
│       │   │   └── 🐘 show.blade.php
│       │   └── 📁 manajemen-user
│       │       ├── 🐘 create.blade.php
│       │       └── 🐘 index.blade.php
│       ├── 📁 partials
│       │   ├── 🐘 header.blade.php
│       │   ├── 🐘 sidebar.blade.php
│       │   ├── 🐘 user-dropdown.blade old.php
│       │   └── 🐘 user-dropdown.blade.php
│       ├── 📁 profile
│       │   ├── 📁 partials
│       │   │   ├── 🐘 delete-user-form.blade.php
│       │   │   ├── 🐘 update-password-form.blade.php
│       │   │   └── 🐘 update-profile-information-form.blade.php
│       │   └── 🐘 edit.blade.php
│       ├── 🐘 dashboard.blade.php
│       └── 🐘 welcome.blade.php
├── 📁 routes
│   ├── 🐘 auth.php
│   ├── 🐘 console.php
│   └── 🐘 web.php
├── 📁 storage
│   ├── 📁 app
│   │   ├── 📁 private
│   │   │   └── ⚙️ .gitignore
│   │   ├── 📁 public
│   │   │   └── ⚙️ .gitignore
│   │   └── ⚙️ .gitignore
│   ├── 📁 framework
│   │   ├── 📁 sessions
│   │   │   └── ⚙️ .gitignore
│   │   ├── 📁 testing
│   │   │   └── ⚙️ .gitignore
│   │   ├── 📁 views
│   │   │   ├── ⚙️ .gitignore
│   │   │   ├── 🐘 09b0d1c7841be30d8313618d55f39818.php
│   │   │   ├── 🐘 179aa1a577f3bbd6f42e7765e4bbeda3.php
│   │   │   ├── 🐘 1de526a7f99d393398847bd764c425d9.php
│   │   │   ├── 🐘 2140af2e63127884937ba7153b7fc769.php
│   │   │   ├── 🐘 24c5aea13237dd3698cc20596b1f1608.php
│   │   │   ├── 🐘 251709dccbb793858bec17ee628c5c18.php
│   │   │   ├── 🐘 2b0cfe0de7c88f93657a7452cb83767c.php
│   │   │   ├── 🐘 2ecb8be0c2fcdb2f966a546b7e2cd41d.php
│   │   │   ├── 🐘 34081941898be1fa8809050f772bc901.php
│   │   │   ├── 🐘 37c74ec3b749cece255bb011033779e8.php
│   │   │   ├── 🐘 3b2a03c7bea2f418fad653a66a0d975f.php
│   │   │   ├── 🐘 414dc4992e7598afd2db76a820b74ae7.php
│   │   │   ├── 🐘 4386cd9b5c57a96f096b0b4a86556519.php
│   │   │   ├── 🐘 44c70085635a7864a9273ae7f9140df7.php
│   │   │   ├── 🐘 46121b497d1f2fe6d2f209dd414c7839.php
│   │   │   ├── 🐘 470919e06ff681bfe55159026207b45c.php
│   │   │   ├── 🐘 47e393f41458dd01adf29f68f65774de.php
│   │   │   ├── 🐘 4a929c903f7dc2178b2d9afb234b208f.php
│   │   │   ├── 🐘 4cce2ce59a9e904dffd3ac6dabd88c7c.php
│   │   │   ├── 🐘 4f028396537eb051ca064969955af65c.php
│   │   │   ├── 🐘 50ed601443ebbdacbbf13f5f5a0e91c3.php
│   │   │   ├── 🐘 514b335ed6dcc2e9ad38630944bb319b.php
│   │   │   ├── 🐘 52122adc82349bb7d3b124b7a94afb97.php
│   │   │   ├── 🐘 61947875b780e333741a82c1e25ee242.php
│   │   │   ├── 🐘 629da18906c735b218e791e6d4d701fe.php
│   │   │   ├── 🐘 696afb0be60a5984f75924375c32c967.php
│   │   │   ├── 🐘 6b8c3cd78cbcabab3fd9460cc6061105.php
│   │   │   ├── 🐘 7e0bfb7683ec4ed8d18801fcc71460f7.php
│   │   │   ├── 🐘 82b2dd3fcbd36127b1b4b54189d9b46d.php
│   │   │   ├── 🐘 837f3c0eed6480a902c74dd85d6f3319.php
│   │   │   ├── 🐘 84cd3b1193a0a33b0f4d60232e9474b5.php
│   │   │   ├── 🐘 84dfa8bf69e2dd8f76706fbbd521a34a.php
│   │   │   ├── 🐘 92e8f5fc6d690d986dea3283efcc1452.php
│   │   │   ├── 🐘 94a59b250f14e9aeb843c12c6d4baacb.php
│   │   │   ├── 🐘 96daad1367bdc42e79f9436adf69591a.php
│   │   │   ├── 🐘 9a5af1da2f1ccaae49eaebe93088fc63.php
│   │   │   ├── 🐘 9f59287d1c1ad89c12a8fbee74f9ae4d.php
│   │   │   ├── 🐘 a014ccfbcbbd651a668d3deca688d596.php
│   │   │   ├── 🐘 a0d26e9a7a0fa15319a36317f0f5cb7b.php
│   │   │   ├── 🐘 a345d73c3519634fd353085a6e17eef3.php
│   │   │   ├── 🐘 a3a8cb6013aac8ddf00915fe9b5504d6.php
│   │   │   ├── 🐘 ad69b95d858f93938510c664aa7b059c.php
│   │   │   ├── 🐘 ae20956a434f107f0527cd2244f82307.php
│   │   │   ├── 🐘 ae489811b42cd4d571603a911c98a534.php
│   │   │   ├── 🐘 af1d770649bc2058776469924109fe9c.php
│   │   │   ├── 🐘 b6c7df9811cf0b7c67bb6092ebc1b83c.php
│   │   │   ├── 🐘 b7b3505649abfccfd6a6565e6349e5d1.php
│   │   │   ├── 🐘 bd565a99faa84d6472fb760f69e6092a.php
│   │   │   ├── 🐘 bfb576f32e5422b5ec83506ae0ec4b0d.php
│   │   │   ├── 🐘 c20817767854f01e88dea51d81f7ca0f.php
│   │   │   ├── 🐘 c78f3ca06dfa91041356acc7bb188cdc.php
│   │   │   ├── 🐘 cdd4677f54372d4ad4dabeee36985945.php
│   │   │   ├── 🐘 cdf42a0bc2d3dd00c6f351761a5e16a5.php
│   │   │   ├── 🐘 d027beca733bd3c8c93f84b1c5fed577.php
│   │   │   ├── 🐘 d1769082c6c9736d82b91771b23c8ec6.php
│   │   │   ├── 🐘 d92a51e813f15a3f03d2f4759085cf6b.php
│   │   │   ├── 🐘 dcf05bef1d5790092d7ae62097140082.php
│   │   │   ├── 🐘 e13750268a0eaf384448caa01b241227.php
│   │   │   ├── 🐘 e1eb8462ba176bc01805cc6606a755ed.php
│   │   │   ├── 🐘 e2b37a316bef4fc5907aeb3d20dd7bf1.php
│   │   │   ├── 🐘 f2b04670677231762c4ea26eb5f0637e.php
│   │   │   ├── 🐘 f6c9300bd2e1425bbcd1322ef9b8b4a0.php
│   │   │   ├── 🐘 f7e54f6db9e4f47b5babc8dfbe71f638.php
│   │   │   └── 🐘 fe0ce880e1f71de5760f3e7072cdc906.php
│   │   └── ⚙️ .gitignore
│   └── 📁 logs
│       └── ⚙️ .gitignore
├── 📁 tests
│   ├── 📁 Feature
│   │   ├── 📁 Auth
│   │   │   ├── 🐘 AuthenticationTest.php
│   │   │   ├── 🐘 EmailVerificationTest.php
│   │   │   ├── 🐘 PasswordConfirmationTest.php
│   │   │   ├── 🐘 PasswordResetTest.php
│   │   │   ├── 🐘 PasswordUpdateTest.php
│   │   │   └── 🐘 RegistrationTest.php
│   │   ├── 🐘 ExampleTest.php
│   │   └── 🐘 ProfileTest.php
│   ├── 📁 Unit
│   │   └── 🐘 ExampleTest.php
│   └── 🐘 TestCase.php
├── ⚙️ .editorconfig
├── ⚙️ .env.example
├── ⚙️ .gitattributes
├── ⚙️ .gitignore
├── 📝 README.md
├── 📄 artisan
├── ⚙️ composer.json
├── ⚙️ package-lock.json
├── ⚙️ package.json
├── ⚙️ phpunit.xml
├── 📄 postcss.config.js
├── 📄 tailwind.config.js
└── 📄 vite.config.js
```

---
*Generated by FileTree Pro Extension*
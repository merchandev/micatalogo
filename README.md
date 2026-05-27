# MiCatálogo SaaS - Tema Monolítico Modular

MiCatálogo SaaS es una solución completa en WordPress para crear una plataforma tipo "Software as a Service" (SaaS). Permite a los usuarios registrarse, crear su propia tienda-catálogo digital, subir productos y recibir pedidos directamente en su número de WhatsApp.

Este repositorio contiene el **tema monolítico** que gestiona todo el ciclo de vida del SaaS, eliminando la necesidad de múltiples plugins externos.

## 🚀 Características Principales

- **Pedidos por WhatsApp**: Integración directa donde el carrito de compras envía un mensaje estructurado al WhatsApp del vendedor.
- **Dark Luxury UI**: Un diseño premium, minimalista y con estética oscura (Glassmorphism, resplandores esmeralda y tipografía Outfit).
- **Auto-Instalación (Plug & Play)**: Al activar el tema, genera automáticamente las páginas base (Inicio, Planes, Tutoriales, Legal) y configura la portada estática.
- **Gestión Multi-Tenant**: Lógica de suscripciones, límites de productos por plan y control de onboarding para nuevos vendedores.
- **Panel de Vendedor (Vendor Dashboard)**: Dashboard interno para gestionar productos, variantes (Talla/Color), importación masiva por CSV y listado de pedidos.
- **Rendimiento y Seguridad Core**: Limpieza automática de cabeceras de WordPress, aplicación de Security Headers y carga diferida (defer) de scripts.

## 📁 Estructura del Proyecto

```text
micatalogo-saas/
├── assets/                 # CSS (theme.css), JS y Media
├── includes/               # Lógica del Core (SaaS, Carrito, KYC, WhatsApp, CPTs)
├── page-templates/         # Plantillas de páginas públicas (Inicio, Planes, etc.)
├── templates/              # Plantillas de la tienda (Catálogo, Checkout, Dashboard)
├── functions.php           # Punto de entrada principal y registro de clases
├── style.css               # Declaración del tema (WordPress)
├── index.php / front-page  # Portadas fallback y principal
└── header.php / footer.php # Elementos estructurales base
```

## 🛠️ Instalación

1. Clona o descarga este repositorio como archivo `.zip`.
2. Sube el `.zip` a tu instalación de WordPress en `Apariencia > Temas`.
3. Activa el tema. Automáticamente se generará la estructura base de páginas y menús.
4. *(Opcional)* Si cuentas con una red Multisite, el tema aprovisionará las reglas necesarias al registrar nuevos sitios.

## 💻 Pila Tecnológica

- **Backend**: PHP 7.4+ / WordPress API (Custom Post Types, Meta Queries, REST/AJAX).
- **Frontend**: Vanilla JS, HTML5 semántico, CSS3 moderno (Variables nativas, Flexbox, CSS Grid).
- **Tipografía**: Outfit (Headings), Inter (Body).

---
*Desarrollado para revolucionar el comercio directo sin comisiones.*

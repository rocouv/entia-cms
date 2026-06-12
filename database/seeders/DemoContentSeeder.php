<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Section;
use App\Models\Site;
use Illuminate\Database\Seeder;

class DemoContentSeeder extends Seeder
{
    /**
     * Seed demo public content for first Entia client.
     */
    public function run(): void
    {
        $site = Site::query()->with(['client', 'settings'])->firstOrFail();

        $site->client->update([
            'name' => 'Lumina Publicidad',
            'legal_name' => 'Lumina Publicidad S.A. de C.V.',
            'contact_email' => 'hola@luminapublicidad.test',
            'contact_phone' => '+52 55 1000 2400',
        ]);

        $site->update([
            'name' => 'Lumina Publicidad',
            'domain' => 'luminapublicidad.test',
            'is_active' => true,
        ]);

        $site->settings()->updateOrCreate(
            ['site_id' => $site->id],
            [
                'site_name' => 'Lumina Publicidad',
                'tagline' => 'Ideas con direccion. Campanas con impacto.',
                'contact_email' => 'hola@luminapublicidad.test',
                'contact_phone' => '+52 55 1000 2400',
                'address' => 'Colonia Roma Norte, Ciudad de Mexico',
                'meta_title' => 'Lumina Publicidad | Agencia creativa y estrategica',
                'meta_description' => 'Agencia publicitaria ficticia especializada en estrategia de marca, campanas digitales, contenido creativo y crecimiento comercial.',
                'social_links' => [
                    'instagram' => 'https://instagram.com/luminapublicidad',
                    'linkedin' => 'https://linkedin.com/company/luminapublicidad',
                    'behance' => 'https://behance.net/luminapublicidad',
                ],
            ],
        );

        $pages = $this->pages();
        $demoSlugs = array_column($pages, 'slug');

        Page::query()
            ->whereBelongsTo($site)
            ->whereNotIn('slug', $demoSlugs)
            ->update([
                'is_home' => false,
                'is_published' => false,
                'show_in_navigation' => false,
            ]);

        foreach ($pages as $pageData) {
            $page = Page::query()->updateOrCreate(
                [
                    'site_id' => $site->id,
                    'slug' => $pageData['slug'],
                ],
                [
                    'title' => $pageData['title'],
                    'excerpt' => $pageData['excerpt'],
                    'body' => $pageData['body'],
                    'is_home' => $pageData['is_home'],
                    'is_published' => true,
                    'show_in_navigation' => true,
                    'navigation_label' => $pageData['navigation_label'],
                    'sort_order' => $pageData['sort_order'],
                    'meta_title' => $pageData['meta_title'],
                    'meta_description' => $pageData['meta_description'],
                ],
            );

            foreach ($pageData['sections'] as $sectionData) {
                Section::query()->updateOrCreate(
                    [
                        'page_id' => $page->id,
                        'sort_order' => $sectionData['sort_order'],
                    ],
                    [
                        'type' => $sectionData['type'],
                        'content' => $sectionData['content'],
                        'settings' => $sectionData['settings'] ?? [],
                        'is_visible' => true,
                    ],
                );
            }
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function pages(): array
    {
        return [
            [
                'title' => 'Inicio',
                'slug' => 'inicio',
                'excerpt' => 'Agencia publicitaria ficticia para mostrar Entia CMS con contenido realista, editable y listo para navegar.',
                'body' => 'Lumina Publicidad combina estrategia, creatividad y medicion para construir marcas memorables.',
                'is_home' => true,
                'navigation_label' => 'Inicio',
                'sort_order' => 0,
                'meta_title' => 'Lumina Publicidad | Estrategia, creatividad y resultados',
                'meta_description' => 'Agencia publicitaria ficticia enfocada en branding, campanas digitales, contenido y crecimiento comercial.',
                'sections' => [
                    [
                        'type' => 'hero',
                        'sort_order' => 0,
                        'content' => [
                            'title' => 'Marcas que se ven, se entienden y se recuerdan',
                            'subtitle' => 'Creamos estrategia, identidad y campanas digitales para empresas que quieren crecer con claridad.',
                            'button_text' => 'Ver servicios',
                            'button_url' => '/servicios',
                        ],
                        'settings' => ['background_color' => 'surface-container-lowest'],
                    ],
                    [
                        'type' => 'cards',
                        'sort_order' => 10,
                        'content' => [
                            'title' => 'Lo que Lumina resuelve',
                            'items' => [
                                [
                                    'icon' => 'strategy',
                                    'title' => 'Estrategia de marca',
                                    'description' => 'Posicionamiento, voz, promesa y narrativa para competir sin ruido.',
                                ],
                                [
                                    'icon' => 'campaign',
                                    'title' => 'Campanas integrales',
                                    'description' => 'Concepto, piezas, pauta y seguimiento para lanzamientos o temporadas clave.',
                                ],
                                [
                                    'icon' => 'monitoring',
                                    'title' => 'Medicion continua',
                                    'description' => 'Reportes claros, aprendizaje accionable y optimizacion por resultados.',
                                ],
                            ],
                        ],
                        'settings' => ['background_color' => 'white'],
                    ],
                    [
                        'type' => 'text_block',
                        'sort_order' => 20,
                        'content' => [
                            'title' => 'Una agencia pequena con mirada grande',
                            'body' => 'Lumina trabaja con equipos comerciales, fundadores y lideres de marketing que necesitan ordenar su comunicacion, salir al mercado con fuerza y sostener presencia digital sin improvisar.',
                        ],
                        'settings' => ['background_color' => 'surface-container-lowest'],
                    ],
                    [
                        'type' => 'contact',
                        'sort_order' => 30,
                        'content' => [
                            'title' => 'Hablemos de tu siguiente campana',
                            'body' => 'Cuanta meta, audiencia y fecha. Lumina arma una propuesta clara para avanzar.',
                            'show_form' => true,
                        ],
                        'settings' => ['background_color' => 'white'],
                    ],
                ],
            ],
            [
                'title' => 'Servicios',
                'slug' => 'servicios',
                'excerpt' => 'Servicios publicitarios modulares para marcas que necesitan estrategia, ejecucion y seguimiento.',
                'body' => 'Servicios de estrategia, creatividad, contenido y performance para marcas en crecimiento.',
                'is_home' => false,
                'navigation_label' => 'Servicios',
                'sort_order' => 10,
                'meta_title' => 'Servicios | Lumina Publicidad',
                'meta_description' => 'Branding, campanas digitales, contenido social, pauta y consultoria para marcas en crecimiento.',
                'sections' => [
                    [
                        'type' => 'hero',
                        'sort_order' => 0,
                        'content' => [
                            'title' => 'Servicios para convertir ideas en crecimiento',
                            'subtitle' => 'Puedes contratar un sprint puntual o un acompanamiento mensual segun etapa, presupuesto y objetivos.',
                        ],
                        'settings' => ['background_color' => 'surface-container-lowest'],
                    ],
                    [
                        'type' => 'cards',
                        'sort_order' => 10,
                        'content' => [
                            'title' => 'Menu de servicios',
                            'items' => [
                                [
                                    'icon' => 'draw',
                                    'title' => 'Branding e identidad',
                                    'description' => 'Nombre, concepto, identidad visual, manual basico y mensajes centrales.',
                                ],
                                [
                                    'icon' => 'ads_click',
                                    'title' => 'Campanas digitales',
                                    'description' => 'Concepto creativo, landings, piezas para pauta y reportes de aprendizaje.',
                                ],
                                [
                                    'icon' => 'photo_camera',
                                    'title' => 'Contenido social',
                                    'description' => 'Calendarios, copies, guiones cortos y direccion creativa para redes.',
                                ],
                                [
                                    'icon' => 'analytics',
                                    'title' => 'Performance marketing',
                                    'description' => 'Pauta, testing, embudos simples y optimizacion por conversion.',
                                ],
                                [
                                    'icon' => 'storefront',
                                    'title' => 'Lanzamientos',
                                    'description' => 'Plan completo para presentar producto, servicio, sucursal o nueva marca.',
                                ],
                                [
                                    'icon' => 'school',
                                    'title' => 'Consultoria creativa',
                                    'description' => 'Diagnostico, roadmap y sesiones para equipos que ejecutan internamente.',
                                ],
                            ],
                        ],
                        'settings' => ['background_color' => 'white'],
                    ],
                ],
            ],
            [
                'title' => 'Proyectos',
                'slug' => 'proyectos',
                'excerpt' => 'Casos ficticios que muestran como Lumina estructura retos, ideas y resultados.',
                'body' => 'Portafolio de proyectos demo para visualizar tarjetas y contenido editorial en Entia.',
                'is_home' => false,
                'navigation_label' => 'Proyectos',
                'sort_order' => 20,
                'meta_title' => 'Proyectos | Lumina Publicidad',
                'meta_description' => 'Casos ficticios de branding, campanas, lanzamiento y contenido creados para demo de Entia CMS.',
                'sections' => [
                    [
                        'type' => 'hero',
                        'sort_order' => 0,
                        'content' => [
                            'title' => 'Trabajo ficticio, estructura real',
                            'subtitle' => 'Estos casos demo ayudan a probar paginas, secciones y narrativa publica del CMS.',
                        ],
                        'settings' => ['background_color' => 'surface-container-lowest'],
                    ],
                    [
                        'type' => 'cards',
                        'sort_order' => 10,
                        'content' => [
                            'title' => 'Casos destacados',
                            'items' => [
                                [
                                    'icon' => 'local_cafe',
                                    'title' => 'Bruma Cafe',
                                    'description' => 'Reposicionamiento local, nueva voz de marca y campana de apertura para tres sucursales.',
                                ],
                                [
                                    'icon' => 'fitness_center',
                                    'title' => 'Nexo Fit',
                                    'description' => 'Lanzamiento digital con piezas cortas, pauta geolocalizada y landing de conversion.',
                                ],
                                [
                                    'icon' => 'spa',
                                    'title' => 'Casa Verde',
                                    'description' => 'Identidad visual y calendario social para marca de productos sustentables.',
                                ],
                            ],
                        ],
                        'settings' => ['background_color' => 'white'],
                    ],
                ],
            ],
            [
                'title' => 'Nosotros',
                'slug' => 'nosotros',
                'excerpt' => 'Equipo creativo ficticio con proceso simple: investigar, sintetizar, producir y medir.',
                'body' => 'Lumina es una agencia demo creada para probar contenido publico en Entia CMS.',
                'is_home' => false,
                'navigation_label' => 'Nosotros',
                'sort_order' => 30,
                'meta_title' => 'Nosotros | Lumina Publicidad',
                'meta_description' => 'Conoce la filosofia, proceso y forma de trabajo de Lumina Publicidad.',
                'sections' => [
                    [
                        'type' => 'text_block',
                        'sort_order' => 0,
                        'content' => [
                            'title' => 'Pensar antes de producir',
                            'body' => 'Lumina no arranca por piezas. Arranca por negocio, audiencia y mensaje. Despues convierte esa claridad en identidad, campanas y contenido que puede sostenerse.',
                        ],
                        'settings' => ['background_color' => 'white'],
                    ],
                    [
                        'type' => 'cards',
                        'sort_order' => 10,
                        'content' => [
                            'title' => 'Principios de trabajo',
                            'items' => [
                                [
                                    'icon' => 'psychology',
                                    'title' => 'Claridad primero',
                                    'description' => 'Toda pieza debe responder que decir, a quien, por que ahora y que sigue.',
                                ],
                                [
                                    'icon' => 'bolt',
                                    'title' => 'Produccion agil',
                                    'description' => 'Sprints cortos, entregables visibles y decisiones sin reuniones eternas.',
                                ],
                                [
                                    'icon' => 'query_stats',
                                    'title' => 'Aprendizaje medible',
                                    'description' => 'Cada campana deja datos utiles para mejorar mensaje, oferta y canal.',
                                ],
                            ],
                        ],
                        'settings' => ['background_color' => 'surface-container-lowest'],
                    ],
                ],
            ],
            [
                'title' => 'Contacto',
                'slug' => 'contacto',
                'excerpt' => 'Pide una propuesta ficticia o usa esta pagina para probar futuras integraciones de contacto.',
                'body' => 'Contacto demo de Lumina Publicidad.',
                'is_home' => false,
                'navigation_label' => 'Contacto',
                'sort_order' => 40,
                'meta_title' => 'Contacto | Lumina Publicidad',
                'meta_description' => 'Contacta a Lumina Publicidad para estrategia, campanas digitales o contenido de marca.',
                'sections' => [
                    [
                        'type' => 'contact',
                        'sort_order' => 0,
                        'content' => [
                            'title' => 'Cuentalo en simple',
                            'body' => 'Escribe a hola@luminapublicidad.test o llama al +52 55 1000 2400. El formulario real puede conectarse despues con Resend.',
                            'show_form' => true,
                        ],
                        'settings' => ['background_color' => 'surface-container-lowest'],
                    ],
                    [
                        'type' => 'faq',
                        'sort_order' => 10,
                        'content' => [
                            'title' => 'Preguntas frecuentes',
                            'items' => [
                                [
                                    'question' => 'Cuanto tarda un proyecto de branding?',
                                    'answer' => 'Entre cuatro y ocho semanas, segun alcance, revisiones y materiales necesarios.',
                                ],
                                [
                                    'question' => 'Pueden trabajar solo una campana?',
                                    'answer' => 'Si. Lumina puede ejecutar sprints puntuales sin contrato mensual.',
                                ],
                                [
                                    'question' => 'El formulario ya envia correos?',
                                    'answer' => 'Todavia no. La vista existe, pero falta implementar envio con Resend.',
                                ],
                            ],
                        ],
                        'settings' => ['background_color' => 'white'],
                    ],
                ],
            ],
        ];
    }
}

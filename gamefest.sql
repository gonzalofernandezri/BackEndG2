-- =========================================================
-- GAMEFEST - Base de datos completa desde 0 (MySQL)
-- users + games + events + user_events (N:M)
-- Imágenes: se guarda SOLO el nombre de archivo (del ZIP)
-- =========================================================
DROP DATABASE IF EXISTS gamefest;
CREATE DATABASE gamefest
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE gamefest;
-- =========================
-- USERS
-- =========================
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(120) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('ADMIN','USER') NOT NULL DEFAULT 'USER',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Admin + usuario demo (hash placeholders: sustitúyelos por bcrypt real)
INSERT INTO users (id, username, email, password_hash, role) VALUES
(1, 'admin', 'admin@gamefest.local', '$2b$10$REEMPLAZA_ESTE_HASH_CON_BCRYPT_REAL', 'ADMIN'),
(2, 'alumno', 'alumno@gamefest.local', '$2b$10$REEMPLAZA_ESTE_HASH_CON_BCRYPT_REAL', 'USER');

-- =========================
-- GAMES
-- (manteniendo estructura típica del JSON: titulo/genero/plataformas/imagen/descripcion)
-- =========================
CREATE TABLE games (
  id INT PRIMARY KEY,
  titulo VARCHAR(120) NOT NULL,
  genero VARCHAR(80) NOT NULL,
  plataformas JSON NOT NULL,
  imagen VARCHAR(255) NOT NULL,
  descripcion TEXT NOT NULL
);

-- Imágenes EXACTAS del ZIP: gamefest_resources/games/*.jpg
INSERT INTO games (id, titulo, genero, plataformas, imagen, descripcion) VALUES
(1, 'Minecraft', 'Sandbox', JSON_ARRAY('PC','Consolas','Móviles'), 'minecraft.jpg',
 'Construcción y exploración en mundo abierto. Recolecta recursos, crea herramientas y construye lo que imagines.'),
(2, 'Fortnite', 'Battle Royale', JSON_ARRAY('PC','Consolas','Móviles'), 'fortnite.jpg',
 'Acción competitiva con eventos en directo y modos variados. Construcción, combate y personalización.'),
(3, 'Apex Legends', 'Battle Royale', JSON_ARRAY('PC','Consolas'), 'apex_legends.jpg',
 'Shooter por escuadras con leyendas y habilidades. Ritmo rápido, movilidad y juego en equipo.'),
(4, 'League of Legends', 'MOBA', JSON_ARRAY('PC'), 'league_of_legends.jpg',
 'Estrategia 5v5 con campeones y roles. Control de objetivos, coordinación y dominio del mapa.'),
(5, 'VALORANT', 'Shooter táctico', JSON_ARRAY('PC'), 'valorant.jpg',
 'Shooter 5v5 con agentes y habilidades. Precisión, control de economía y estrategia por rondas.'),
(6, 'Counter-Strike 2', 'Shooter competitivo', JSON_ARRAY('PC'), 'cs2.jpg',
 'Shooter táctico por rondas. Economía, utilidad, coordinación y ejecuciones de equipo.'),
(7, 'Call of Duty', 'Shooter', JSON_ARRAY('PC','Consolas'), 'call_of_duty.jpg',
 'Acción FPS con multijugador competitivo, progresión y modos rápidos centrados en reflejos y mapa.'),
(8, 'Destiny 2', 'Acción / Looter Shooter', JSON_ARRAY('PC','Consolas'), 'destiny2.jpg',
 'Cooperativo y PvP en un universo persistente. Misiones, raids y progresión basada en equipo.'),
(9, 'Elden Ring', 'RPG de acción', JSON_ARRAY('PC','Consolas'), 'elden_ring.jpg',
 'Exploración en mundo abierto, builds y combates exigentes. Narrativa ambiental y descubrimiento constante.');

-- =========================
-- EVENTS
-- (estructura igual a tu JSON: titulo/tipo/fecha/hora/plazasLibres/imagen/descripcion)
-- =========================
CREATE TABLE events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(160) NOT NULL,
  tipo VARCHAR(60) NOT NULL,
  fecha DATE NOT NULL,
  hora TIME NOT NULL,
  plazasLibres INT NOT NULL,
  imagen VARCHAR(255) NOT NULL,
  descripcion TEXT NOT NULL,
  created_by INT NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT chk_plazas_nonneg CHECK (plazasLibres >= 0),
  CONSTRAINT fk_events_created_by FOREIGN KEY (created_by) REFERENCES users(id)
);

CREATE INDEX idx_events_fecha_hora ON events(fecha, hora);

-- Imágenes EXACTAS del ZIP: gamefest_resources/events/*.jpg|png
INSERT INTO events (id, titulo, tipo, fecha, hora, plazasLibres, imagen, descripcion, created_by) VALUES
(1, 'Inauguración oficial GameFest 2025', 'Presentación', '2025-02-13', '10:00', 300, 'inauguracion-oficial-gamefest-2025.jpg', 'Acto de apertura con bienvenida, explicación del programa del fin de semana y presentación de las actividades principales.', 1),
(2, 'Charla: Historia del videojuego moderno', 'Charla', '2025-02-13', '11:30', 150, 'charla-historia-videojuego-moderno.jpg', 'Recorrido por hitos, plataformas y géneros que han marcado la evolución del videojuego desde los 90 hasta hoy.', 1),
(3, 'Taller de Pixel Art', 'Taller', '2025-02-13', '13:00', 40, 'taller-pixel-art.png', 'Taller práctico de pixel art: paletas, sombreado, tiles y animación básica orientada a juegos 2D.', 1),
(4, 'Mesa redonda: Mujeres en la industria del videojuego', 'Mesa Redonda', '2025-02-13', '15:00', 120, 'mesa-redonda-mujeres-industria-videojuego.jpg', 'Debate con profesionales del sector sobre referentes, barreras, oportunidades y experiencias en equipos de desarrollo.', 1),
(5, 'Exhibición de consolas retro', 'Exhibición', '2025-02-13', '16:30', 200, 'exhibicion-consolas-retro.jpg', 'Zona de exposición y juego libre con consolas clásicas, periféricos y selección de títulos históricos.', 1),
(6, 'Charla: Narrativa interactiva en videojuegos', 'Charla', '2025-02-13', '18:00', 100, 'charla-narrativa-interactiva-videojuegos.png', 'Cómo se diseñan decisiones, ramas y consecuencias: estructuras narrativas y ejemplos de narrativa emergente.', 1),
(7, 'Torneo de Rocket League', 'Torneo', '2025-02-13', '19:30', 32, 'torneo-rocket-league-esports.jpg', 'Competición con formato eliminatorio. Check-in 15 minutos antes. Premios para el top 3.', 1),
(8, 'Workshop: Diseño de niveles', 'Taller', '2025-02-13', '21:00', 25, 'taller-diseno-de-niveles.png', 'Diseño práctico de niveles: ritmo, dificultad, señalización, métricas básicas y playtesting iterativo.', 1),
(9, 'Afterwork Gaming & Networking', 'Networking', '2025-02-13', '22:30', 80, 'afterwork-gaming-networking.jpg', 'Encuentro informal para hacer networking, compartir proyectos y conocer a gente del sector.', 1),

(10, 'Charla: El futuro del cloud gaming', 'Charla', '2025-02-14', '10:00', 140, 'charla-futuro-cloud-gaming.png', 'Streaming, latencia, modelos de negocio y retos técnicos. Qué es viable hoy y qué está por llegar.', 1),
(11, 'Taller de Unreal Engine 5', 'Taller', '2025-02-14', '11:30', 50, 'taller-unreal-engine-5.jpg', 'Introducción práctica: creación de escena, iluminación, Blueprints y primeros pasos hacia un prototipo jugable.', 1),
(12, 'Torneo de Valorant', 'Torneo', '2025-02-14', '13:30', 32, 'torneo-valorant-esports.jpg', 'Torneo por equipos con bracket. Se publican reglas y emparejamientos al inicio de la sesión.', 1),
(13, 'Mesa redonda: IA aplicada al gameplay', 'Mesa Redonda', '2025-02-14', '15:00', 110, 'mesa-redonda-ia-aplicada-al-gameplay.png', 'IA en NPCs, generación procedural y herramientas creativas: oportunidades, límites y buenas prácticas.', 1),
(14, 'Charla: Monetización ética en videojuegos', 'Charla', '2025-02-14', '16:30', 90, 'charla-monetizacion-etica-videojuegos.jpg', 'Modelos sostenibles y responsables: transparencia, bienestar del jugador y ejemplos de diseño no agresivo.', 1),
(15, 'Exhibición VR Experience', 'Exhibición', '2025-02-14', '18:00', 60, 'exhibicion-vr-experience.jpg', 'Zona VR con experiencias cortas por turnos. Recomendado reservar plaza y seguir indicaciones de seguridad.', 1),
(16, 'Taller de Audio para Videojuegos', 'Taller', '2025-02-14', '19:30', 35, 'taller-audio-para-videojuegos.jpg', 'Diseño de sonido: FX, música adaptativa, mezcla básica y pautas para integrar audio en motores de juego.', 1),
(17, 'Competición de Speedrun', 'Competición', '2025-02-14', '21:00', 20, 'competicion-speedrun-esports.jpg', 'Competición contrarreloj. Se valoran ejecución, consistencia y cumplimiento de reglas de categoría.', 1),
(18, 'Noche Indie Showcase', 'Exhibición', '2025-02-14', '22:30', 100, 'noche-indie-showcase.jpg', 'Presentación de proyectos indie con demos jugables y feedback para los equipos participantes.', 1),

(19, 'Charla: Desarrollo de videojuegos educativos', 'Charla', '2025-02-15', '10:00', 120, 'charla-videojuegos-educativos.jpg', 'Diseño de juegos con objetivos pedagógicos: motivación, evaluación, accesibilidad y enfoque por competencias.', 1),
(20, 'Torneo de Mario Kart 8 Deluxe', 'Torneo', '2025-02-15', '11:30', 48, 'torneo-mario-kart-8-deluxe.jpg', 'Torneo por rondas con clasificación. Perfecto para todos los niveles: divertido y competitivo a la vez.', 1),
(21, 'Taller de Game Design Document', 'Taller', '2025-02-15', '13:00', 30, 'taller-game-design-document.jpg', 'Cómo redactar un GDD útil: visión, mecánicas, loops, economía, riesgos, alcance y plan de iteración.', 1),
(22, 'Mesa redonda: El futuro del eSports', 'Mesa Redonda', '2025-02-15', '14:30', 100, 'mesa-redonda-futuro-esports.jpg', 'Ligas, organización, comunidad y negocio: mirada 360º con debate entre perfiles competitivos y producción.', 1),
(23, 'Charla: UX y accesibilidad en videojuegos', 'Charla', '2025-02-15', '16:00', 80, 'charla-ux-accesibilidad-videojuegos.jpg', 'Diseño centrado en el jugador: legibilidad, mapeo de controles, opciones de accesibilidad y testing.', 1),
(24, 'Exhibición de arcades clásicos', 'Exhibición', '2025-02-15', '17:30', 150, 'exhibicion-arcades-clasicos.jpg', 'Zona arcade con máquinas recreativas clásicas, desafíos rápidos y ranking de puntuaciones.', 1),
(25, 'Taller de optimización gráfica', 'Taller', '2025-02-15', '19:00', 40, 'taller-optimizacion-grafica.png', 'Optimización de rendimiento: perfiles, draw calls, LODs, texturas, sombras y estrategias de escalado.', 1),
(26, 'Competición de Cosplay', 'Competición', '2025-02-15', '20:30', 60, 'competicion-cosplay.jpg', 'Concurso de cosplay con jurado. Se valora caracterización, confección, puesta en escena y originalidad.', 1),
(27, 'Clausura GameFest 2025', 'Presentación', '2025-02-15', '22:00', 300, 'clausura-gamefest-2025.jpg', 'Cierre con resumen del fin de semana, agradecimientos, entrega de premios y anuncio de la próxima edición.', 1);

-- =========================
-- USER_EVENTS (N:M inscripciones)
-- =========================
CREATE TABLE user_events (
  user_id INT NOT NULL,
  event_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (user_id, event_id), -- evita duplicados
  CONSTRAINT fk_user_events_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_user_events_event FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

CREATE INDEX idx_user_events_user ON user_events(user_id);
CREATE INDEX idx_user_events_event ON user_events(event_id);

-- Seed opcional: el usuario "alumno" se apunta a 3 eventos
INSERT INTO user_events (user_id, event_id) VALUES
(2, 2),
(2, 11),
(2, 20);

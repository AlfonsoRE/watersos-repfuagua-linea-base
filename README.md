# WaterSOS – REPFUAGUA: Línea base de seguridad

Repositorio de línea base del proyecto TecNM 10249.21-PD, parte de la tesis de maestría "Detección y corrección de fallas de seguridad en el sistema de reportes de fugas de agua WaterSOS–REPFUAGUA con apoyo de IA generativa".

Contiene el código fuente original, sin modificar, de la app Android WaterSOS y la plataforma web REPFUAGUA, junto con la evidencia completa de la validación de la suite de 14 casos de prueba de seguridad contra ese código.

## Contenido

- `WaterSOS/` — código fuente original de la app Android (Java).
- `REPFUAGUA/` — código fuente original de la plataforma web (PHP/MySQL).
- `Evidencia/` — evidencia de la validación de los 14 casos de prueba (TC-01 a TC-14) contra el código original: capturas, respuestas de Postman, y los reportes de los escaneos base independientes con MobSF (análisis estático del APK) y OWASP ZAP (análisis dinámico de REPFUAGUA).
- `Registro_Experimento_WaterSOS.xlsx` — matriz de los 14 casos de prueba, con hallazgos documentados por CWE, severidad y observaciones.

## Congelación de la línea base

Esta suite de 14 casos de prueba quedó congelada el 21 de octubre de 2026, antes de iniciar la fase de corrección asistida por IA (comparación entre OpenCode y Claude).

- Tag: `linea-base-v1.0`
- Hash de integridad (commit): `e605fbc7075b9efe8104ae4718cecee368b5764d`

A partir de ese commit se crearon dos repositorios independientes para la fase de corrección:
- [watersos-repfuagua-opencode](https://github.com/AlfonsoRE/watersos-repfuagua-opencode)
- [watersos-repfuagua-claude](https://github.com/AlfonsoRE/watersos-repfuagua-claude)

Este repositorio puede seguir recibiendo commits con evidencia adicional después de la congelación; el código fuente original no se modifica tras el tag `linea-base-v1.0`.

## Autores

- Nicazio Ramírez Lozano — Instituto Tecnológico Superior de Alvarado (ITSAV)
- Alfonso Rosas Escobedo — Instituto Tecnológico Superior de Alvarado (ITSAV), asesor

---------------------------------------------------------------------------------------------------
-- Para custodios
---------------------------------------------------------------------------------------------------
SELECT 
    M.id_movimiento,
    M.id_plantilla,
    M.obs_movimiento,
    M.fecha_movimiento,
    M.dato_anterior,
    M.dato_nuevo,
    M.codigo_ant AS codigo_ant_actual,
    PA.PERSON_NO AS codigo_ant_nuevo,
    M.codigo_nue AS codigo_nue_actual,
    PN.PERSON_NO AS codigo_nue_nuevo
FROM dbo.MOVIMIENTO M
OUTER APPLY (
    SELECT TOP 1 P.PERSON_NO
    FROM dbo.PERSON_NO P
    WHERE LTRIM(RTRIM(P.PERSON_NOM)) = LTRIM(RTRIM(CAST(M.dato_anterior AS varchar(255))))
    ORDER BY P.ID_PERSON
) PA
OUTER APPLY (
    SELECT TOP 1 P.PERSON_NO
    FROM dbo.PERSON_NO P
    WHERE LTRIM(RTRIM(P.PERSON_NOM)) = LTRIM(RTRIM(CAST(M.dato_nuevo AS varchar(255))))
    ORDER BY P.ID_PERSON
) PN
WHERE M.obs_movimiento LIKE '%custodio%'
  AND M.fecha_movimiento >= '2026-07-01'
  AND M.fecha_movimiento <= CAST(GETDATE() AS date)
  AND (M.codigo_ant IS NULL OR M.codigo_nue IS NULL)
ORDER BY M.id_movimiento;


---------------------------------------------------------------------------------------------------
BEGIN TRAN;

UPDATE M
SET 
    M.codigo_ant = PA.PERSON_NO,
    M.codigo_nue = PN.PERSON_NO
FROM dbo.MOVIMIENTO M
OUTER APPLY (
    SELECT TOP 1 P.PERSON_NO
    FROM dbo.PERSON_NO P
    WHERE LTRIM(RTRIM(P.PERSON_NOM)) = LTRIM(RTRIM(CAST(M.dato_anterior AS varchar(255))))
    ORDER BY P.ID_PERSON
) PA
OUTER APPLY (
    SELECT TOP 1 P.PERSON_NO
    FROM dbo.PERSON_NO P
    WHERE LTRIM(RTRIM(P.PERSON_NOM)) = LTRIM(RTRIM(CAST(M.dato_nuevo AS varchar(255))))
    ORDER BY P.ID_PERSON
) PN
WHERE M.obs_movimiento LIKE '%custodio%'
  AND M.fecha_movimiento >= '2026-07-01'
  AND M.fecha_movimiento <= CAST(GETDATE() AS date)
  AND (M.codigo_ant IS NULL OR M.codigo_nue IS NULL);

-- revisa el resultado
SELECT id_movimiento, dato_anterior, codigo_ant, dato_nuevo, codigo_nue
FROM dbo.MOVIMIENTO
WHERE obs_movimiento LIKE '%custodio%'
  AND fecha_movimiento >= '2026-07-01'
  AND fecha_movimiento <= CAST(GETDATE() AS date);

-- si todo está bien:
COMMIT;
-- si algo salió mal:
-- ROLLBACK;


---------------------------------------------------------------------------------------------------
-- Para localizacion
---------------------------------------------------------------------------------------------------

SELECT 
    M.id_movimiento,
    M.id_plantilla,
    M.obs_movimiento,
    M.fecha_movimiento,
    M.dato_anterior,
    M.dato_nuevo,
    M.codigo_ant AS codigo_ant_actual,
    LA.EMPLAZAMIENTO AS codigo_ant_nuevo,
    M.codigo_nue AS codigo_nue_actual,
    LN.EMPLAZAMIENTO AS codigo_nue_nuevo
FROM dbo.MOVIMIENTO M
OUTER APPLY (
    SELECT TOP 1 L.EMPLAZAMIENTO
    FROM dbo.LOCATION L
    WHERE LTRIM(RTRIM(L.DENOMINACION)) = LTRIM(RTRIM(CAST(M.dato_anterior AS varchar(255))))
    ORDER BY L.ID_LOCATION
) LA
OUTER APPLY (
    SELECT TOP 1 L.EMPLAZAMIENTO
    FROM dbo.LOCATION L
    WHERE LTRIM(RTRIM(L.DENOMINACION)) = LTRIM(RTRIM(CAST(M.dato_nuevo AS varchar(255))))
    ORDER BY L.ID_LOCATION
) LN
WHERE (M.obs_movimiento LIKE '%localizaci%' OR M.obs_movimiento LIKE '%emplazamiento%')
  AND M.fecha_movimiento >= '2026-07-01'
  AND M.fecha_movimiento <= CAST(GETDATE() AS date)
  AND (M.codigo_ant IS NULL OR M.codigo_nue IS NULL)
ORDER BY M.id_movimiento;


---------------------------------------------------------------------------------------------------

BEGIN TRAN;

UPDATE M
SET
    M.codigo_ant = LA.EMPLAZAMIENTO,
    M.codigo_nue = LN.EMPLAZAMIENTO
FROM dbo.MOVIMIENTO M
OUTER APPLY (
    SELECT TOP 1 L.EMPLAZAMIENTO
    FROM dbo.LOCATION L
    WHERE LTRIM(RTRIM(L.DENOMINACION)) = LTRIM(RTRIM(CAST(M.dato_anterior AS varchar(255))))
    ORDER BY L.ID_LOCATION
) LA
OUTER APPLY (
    SELECT TOP 1 L.EMPLAZAMIENTO
    FROM dbo.LOCATION L
    WHERE LTRIM(RTRIM(L.DENOMINACION)) = LTRIM(RTRIM(CAST(M.dato_nuevo AS varchar(255))))
    ORDER BY L.ID_LOCATION
) LN
WHERE (M.obs_movimiento LIKE '%localizaci%' OR M.obs_movimiento LIKE '%emplazamiento%')
  AND M.fecha_movimiento >= '2026-07-01'
  AND M.fecha_movimiento <= CAST(GETDATE() AS date)
  AND (M.codigo_ant IS NULL OR M.codigo_nue IS NULL);

-- revisa el resultado
SELECT id_movimiento, dato_anterior, codigo_ant, dato_nuevo, codigo_nue
FROM dbo.MOVIMIENTO
WHERE (obs_movimiento LIKE '%localizaci%' OR obs_movimiento LIKE '%emplazamiento%')
  AND fecha_movimiento >= '2026-07-01'
  AND fecha_movimiento <= CAST(GETDATE() AS date);

-- si todo está bien:
COMMIT;
-- si algo salió mal:
-- ROLLBACK;

---------------------------------------------------------------------------------------------------
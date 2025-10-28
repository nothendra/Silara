/*
 Navicat Premium Data Transfer

 Source Server         : andra
 Source Server Type    : PostgreSQL
 Source Server Version : 180000 (180000)
 Source Host           : localhost:5432
 Source Catalog        : lapor_pak
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 180000 (180000)
 File Encoding         : 65001

 Date: 28/10/2025 16:34:06
*/


-- ----------------------------
-- Sequence structure for aduans_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "aduans_id_seq";
CREATE SEQUENCE "aduans_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for migrations_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "migrations_id_seq";
CREATE SEQUENCE "migrations_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for personal_access_tokens_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "personal_access_tokens_id_seq";
CREATE SEQUENCE "personal_access_tokens_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for recommendations_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "recommendations_id_seq";
CREATE SEQUENCE "recommendations_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for users_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "users_id_seq";
CREATE SEQUENCE "users_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for aduans
-- ----------------------------
DROP TABLE IF EXISTS "aduans";
CREATE TABLE "aduans" (
  "id" int8 NOT NULL DEFAULT nextval('aduans_id_seq'::regclass),
  "judul" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "deskripsi" text COLLATE "pg_catalog"."default" NOT NULL,
  "foto" varchar(255) COLLATE "pg_catalog"."default",
  "tanggal" date NOT NULL,
  "user_id" int4 NOT NULL,
  "status" int4 NOT NULL DEFAULT 1,
  "created_at" timestamp(0),
  "updated_at" timestamp(0)
)
;

-- ----------------------------
-- Records of aduans
-- ----------------------------
BEGIN;
INSERT INTO "aduans" ("id", "judul", "deskripsi", "foto", "tanggal", "user_id", "status", "created_at", "updated_at") VALUES (4, 'tembok runtuh', 'pos kamling kita bubar', 'aduan/d8ZspXoMLg8IJDahGgMJz8bmBPA1J2B3zXCLDXYa.png', '2025-12-10', 5, 1, '2025-10-24 06:33:59', '2025-10-24 06:33:59'), (5, 'jembatan roboh', 'depan rumah haji naim', 'aduan/kG9PoCmHebSApDitZZJoRkksmpW0Dvit9EHtvO50.png', '2025-12-11', 5, 1, '2025-10-24 06:34:38', '2025-10-24 06:34:38'), (2, 'jalan berlubang', 'di depan rumah pa jumal', 'aduan/GvQzW61qgv5OMRjDRNN0IETiscK3E63AInGwuf3d.png', '2025-12-12', 4, 2, '2025-10-22 11:16:26', '2025-10-24 07:26:06'), (3, 'genteng pos bocor', 'pos kamling kita bubar', 'aduan/JyPTytJcqCag5fv8UbvlCLVEEl9Hrg1qXSz68Oj5.png', '2025-12-12', 3, 3, '2025-10-22 11:18:26', '2025-10-24 07:29:46'), (1, 'lampu rusak', 'di depan rumah pa jumaidi', 'aduan/dvpdkFxT10RK163h7N5JVTsrYF9p2hjj0tXUwnPJ.png', '2025-12-12', 4, 2, '2025-10-22 10:44:00', '2025-10-24 07:33:05'), (6, 'jembatan roboh', 'depan rumah haji naim', 'aduan/ZKnCc4S5jfuEpYC1YBnhQCJgPqSQUQkappy4A6b9.png', '2025-12-11', 5, 1, '2025-10-24 10:56:47', '2025-10-24 10:56:47'), (7, 'jembatan roboh', 'depan rumah haji naim', 'aduan/D8pUct6LJG0Y5kxoVGTft4jyW6vC1i1FNZFMGIOZ.png', '2025-12-11', 5, 1, '2025-10-24 10:59:08', '2025-10-24 10:59:08'), (8, 'jembatan roboh', 'depan rumah haji naim', 'aduan/jV71XxKXo8dWL6k1vHxVETTNXL1R6HGUH0KN1AgZ.png', '2025-12-11', 5, 1, '2025-10-24 11:03:01', '2025-10-24 11:03:01');
COMMIT;

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS "cache";
CREATE TABLE "cache" (
  "key" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "value" text COLLATE "pg_catalog"."default" NOT NULL,
  "expiration" int4 NOT NULL
)
;

-- ----------------------------
-- Records of cache
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS "cache_locks";
CREATE TABLE "cache_locks" (
  "key" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "owner" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "expiration" int4 NOT NULL
)
;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS "migrations";
CREATE TABLE "migrations" (
  "id" int4 NOT NULL DEFAULT nextval('migrations_id_seq'::regclass),
  "migration" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "batch" int4 NOT NULL
)
;

-- ----------------------------
-- Records of migrations
-- ----------------------------
BEGIN;
INSERT INTO "migrations" ("id", "migration", "batch") VALUES (1, '2025_10_13_024402_create_personal_access_tokens_table', 1), (2, '2025_10_13_083923_create_aduans_table', 1), (3, '2025_10_22_013626_create_users_table', 1), (4, '2025_10_24_024754_create_recommendations_table', 2), (5, '2025_10_24_031957_create_cache_table', 3), (6, '2025_10_24_031958_create_sessions_table', 3);
COMMIT;

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS "personal_access_tokens";
CREATE TABLE "personal_access_tokens" (
  "id" int8 NOT NULL DEFAULT nextval('personal_access_tokens_id_seq'::regclass),
  "tokenable_type" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "tokenable_id" int8 NOT NULL,
  "name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "token" varchar(64) COLLATE "pg_catalog"."default" NOT NULL,
  "abilities" text COLLATE "pg_catalog"."default",
  "last_used_at" timestamp(0),
  "expires_at" timestamp(0),
  "created_at" timestamp(0),
  "updated_at" timestamp(0)
)
;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------
BEGIN;
INSERT INTO "personal_access_tokens" ("id", "tokenable_type", "tokenable_id", "name", "token", "abilities", "last_used_at", "expires_at", "created_at", "updated_at") VALUES (1, 'App\Models\User', 1, 'auth_token', 'fcda5048526f67930a957c11019bd4ff52ef01d4ca0a2d9ce06254895fb0da99', '["*"]', NULL, NULL, '2025-10-22 01:52:08', '2025-10-22 01:52:08'), (6, 'App\Models\User', 2, 'auth_token', '1567b06f3644f40aaa3ee27e33514af4a8efa3d300cf3999d58584c817fed842', '["*"]', '2025-10-24 03:43:50', NULL, '2025-10-24 03:22:17', '2025-10-24 03:43:50'), (7, 'App\Models\User', 4, 'auth_token', '4f6e25f91d843245036a901af123fd1df2a604c7c07c8ac90f581219b17ad38d', '["*"]', '2025-10-24 03:44:03', NULL, '2025-10-24 03:43:00', '2025-10-24 03:44:03'), (2, 'App\Models\User', 4, 'auth_token', 'c6eaeec402cdb791610c495653241a7255ffa692dc58b9f78388f4af61b33287', '["*"]', '2025-10-22 11:16:26', NULL, '2025-10-22 10:37:25', '2025-10-22 11:16:26'), (4, 'App\Models\User', 3, 'auth_token', 'fe5d9836d9fbe9e52d3ebd643e2ca56e507c89c87e83516b0c5854b8881a8f30', '["*"]', '2025-10-22 11:18:26', NULL, '2025-10-22 11:15:27', '2025-10-22 11:18:26'), (10, 'App\Models\User', 4, 'auth_token', 'e8a61068a0f003f12389cca41b2f3d35358cf9dbe0c006ed596f5736cde8d65b', '["*"]', '2025-10-24 10:22:40', NULL, '2025-10-24 06:37:18', '2025-10-24 10:22:40'), (9, 'App\Models\User', 2, 'auth_token', '79f98bc2f5e712bc0edad9ade250dbae155545c073a53ecfc1283f8271641419', '["*"]', '2025-10-24 10:22:49', NULL, '2025-10-24 06:35:28', '2025-10-24 10:22:49'), (11, 'App\Models\User', 1, 'auth_token', 'e5e63415fd46bb4c3aa56f7bfd8e5cdc6c177b115335b26c9f9d73de605616f5', '["*"]', '2025-10-24 10:23:13', NULL, '2025-10-24 06:50:08', '2025-10-24 10:23:13'), (3, 'App\Models\User', 1, 'auth_token', '12e1c4447966ca6974082951dcce84ffe627c89ba3210fea0217beb4eae0b8e6', '["*"]', '2025-10-24 03:08:12', NULL, '2025-10-22 10:37:36', '2025-10-24 03:08:12'), (8, 'App\Models\User', 5, 'auth_token', '671b8807d2eaee8aa8ac77c30e978bc5336afda52ef976bbdf837236e5e26082', '["*"]', '2025-10-24 11:03:01', NULL, '2025-10-24 06:32:45', '2025-10-24 11:03:01'), (5, 'App\Models\User', 2, 'auth_token', 'fa513bdf281df1dda25cbdc1526bbb2ada1a3fb42a9edf893bb2c635b4bf48f2', '["*"]', '2025-10-24 03:18:38', NULL, '2025-10-24 03:07:49', '2025-10-24 03:18:38');
COMMIT;

-- ----------------------------
-- Table structure for recommendations
-- ----------------------------
DROP TABLE IF EXISTS "recommendations";
CREATE TABLE "recommendations" (
  "id" int8 NOT NULL DEFAULT nextval('recommendations_id_seq'::regclass),
  "aduan_id" int8 NOT NULL,
  "rt_id" int8 NOT NULL,
  "recommended_status" int4 NOT NULL,
  "notes" text COLLATE "pg_catalog"."default",
  "approval_status" varchar(255) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'pending'::character varying,
  "approved_by" int8,
  "admin_notes" text COLLATE "pg_catalog"."default",
  "approved_at" timestamp(0),
  "created_at" timestamp(0),
  "updated_at" timestamp(0)
)
;

-- ----------------------------
-- Records of recommendations
-- ----------------------------
BEGIN;
INSERT INTO "recommendations" ("id", "aduan_id", "rt_id", "recommended_status", "notes", "approval_status", "approved_by", "admin_notes", "approved_at", "created_at", "updated_at") VALUES (1, 1, 2, 1, NULL, 'approved', 1, NULL, '2025-10-24 07:25:49', '2025-10-24 06:46:01', '2025-10-24 07:25:49'), (2, 2, 2, 2, NULL, 'approved', 1, NULL, '2025-10-24 07:26:06', '2025-10-24 06:46:35', '2025-10-24 07:26:06'), (3, 3, 2, 3, NULL, 'approved', 1, 'Laporan diterima dan akan segera ditindaklanjuti.', '2025-10-24 07:29:46', '2025-10-24 06:47:01', '2025-10-24 07:29:46'), (4, 3, 2, 3, NULL, 'pending', NULL, NULL, NULL, '2025-10-24 10:22:49', '2025-10-24 10:22:49');
COMMIT;

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS "sessions";
CREATE TABLE "sessions" (
  "id" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "user_id" int8,
  "ip_address" varchar(45) COLLATE "pg_catalog"."default",
  "user_agent" text COLLATE "pg_catalog"."default",
  "payload" text COLLATE "pg_catalog"."default" NOT NULL,
  "last_activity" int4 NOT NULL
)
;

-- ----------------------------
-- Records of sessions
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS "users";
CREATE TABLE "users" (
  "id" int8 NOT NULL DEFAULT nextval('users_id_seq'::regclass),
  "name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "email" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "email_verified_at" timestamp(0),
  "password" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "role" varchar(255) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'customer'::character varying,
  "remember_token" varchar(100) COLLATE "pg_catalog"."default",
  "created_at" timestamp(0),
  "updated_at" timestamp(0)
)
;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO "users" ("id", "name", "email", "email_verified_at", "password", "role", "remember_token", "created_at", "updated_at") VALUES (1, 'Admin', 'admin@lapor.com', NULL, '$2y$12$KlHKCFfKIEKxdA/UowpUfOiWVLKd99K4glLPmngDUPdlYLngpqj7.', 'admin', NULL, '2025-10-22 01:40:19', '2025-10-22 01:40:19'), (2, 'RT 001', 'rt@lapor.com', NULL, '$2y$12$LItnmLamWP99eFO/3ENXY.V8COAqqrfkL8dKnZrSDdmNWzL/7Pgay', 'rt', NULL, '2025-10-22 01:40:20', '2025-10-22 01:40:20'), (3, 'Warga Test', 'warga@lapor.com', NULL, '$2y$12$zPpsXW5yndVIxjURo7yMbuYj1Q0YE2qBwR4.VQ3z1t6BkP2Qkq4Z2', 'warga', NULL, '2025-10-22 01:40:20', '2025-10-22 01:40:20'), (4, 'sahfira', 'warga.sahfira@lapor.com', NULL, '$2y$12$TQgZKLobY80h6vMuqVl2Eu6KuejCeLJklzf2ZD/mhBNmeCOgbFpDG', 'warga', NULL, '2025-10-22 10:37:25', '2025-10-22 10:37:25'), (5, 'devita', 'warga.devita@lapor.com', NULL, '$2y$12$RPZ2NpDV7l7wZkO5AR/jEOlIxACuHldfRN7M3Ih3nXalqcO2U9m52', 'warga', NULL, '2025-10-24 06:32:45', '2025-10-24 06:32:45');
COMMIT;

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "aduans_id_seq"
OWNED BY "aduans"."id";
SELECT setval('"aduans_id_seq"', 8, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "migrations_id_seq"
OWNED BY "migrations"."id";
SELECT setval('"migrations_id_seq"', 6, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "personal_access_tokens_id_seq"
OWNED BY "personal_access_tokens"."id";
SELECT setval('"personal_access_tokens_id_seq"', 11, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "recommendations_id_seq"
OWNED BY "recommendations"."id";
SELECT setval('"recommendations_id_seq"', 4, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "users_id_seq"
OWNED BY "users"."id";
SELECT setval('"users_id_seq"', 5, true);

-- ----------------------------
-- Primary Key structure for table aduans
-- ----------------------------
ALTER TABLE "aduans" ADD CONSTRAINT "aduans_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table cache
-- ----------------------------
ALTER TABLE "cache" ADD CONSTRAINT "cache_pkey" PRIMARY KEY ("key");

-- ----------------------------
-- Primary Key structure for table cache_locks
-- ----------------------------
ALTER TABLE "cache_locks" ADD CONSTRAINT "cache_locks_pkey" PRIMARY KEY ("key");

-- ----------------------------
-- Primary Key structure for table migrations
-- ----------------------------
ALTER TABLE "migrations" ADD CONSTRAINT "migrations_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table personal_access_tokens
-- ----------------------------
CREATE INDEX "personal_access_tokens_tokenable_type_tokenable_id_index" ON "personal_access_tokens" USING btree (
  "tokenable_type" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "tokenable_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table personal_access_tokens
-- ----------------------------
ALTER TABLE "personal_access_tokens" ADD CONSTRAINT "personal_access_tokens_token_unique" UNIQUE ("token");

-- ----------------------------
-- Primary Key structure for table personal_access_tokens
-- ----------------------------
ALTER TABLE "personal_access_tokens" ADD CONSTRAINT "personal_access_tokens_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Checks structure for table recommendations
-- ----------------------------
ALTER TABLE "recommendations" ADD CONSTRAINT "recommendations_approval_status_check" CHECK (approval_status::text = ANY (ARRAY['pending'::character varying, 'approved'::character varying, 'rejected'::character varying]::text[]));

-- ----------------------------
-- Primary Key structure for table recommendations
-- ----------------------------
ALTER TABLE "recommendations" ADD CONSTRAINT "recommendations_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table sessions
-- ----------------------------
CREATE INDEX "sessions_last_activity_index" ON "sessions" USING btree (
  "last_activity" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "sessions_user_id_index" ON "sessions" USING btree (
  "user_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table sessions
-- ----------------------------
ALTER TABLE "sessions" ADD CONSTRAINT "sessions_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Uniques structure for table users
-- ----------------------------
ALTER TABLE "users" ADD CONSTRAINT "users_email_unique" UNIQUE ("email");

-- ----------------------------
-- Primary Key structure for table users
-- ----------------------------
ALTER TABLE "users" ADD CONSTRAINT "users_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Keys structure for table recommendations
-- ----------------------------
ALTER TABLE "recommendations" ADD CONSTRAINT "recommendations_aduan_id_foreign" FOREIGN KEY ("aduan_id") REFERENCES "aduans" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE "recommendations" ADD CONSTRAINT "recommendations_approved_by_foreign" FOREIGN KEY ("approved_by") REFERENCES "users" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE "recommendations" ADD CONSTRAINT "recommendations_rt_id_foreign" FOREIGN KEY ("rt_id") REFERENCES "users" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;

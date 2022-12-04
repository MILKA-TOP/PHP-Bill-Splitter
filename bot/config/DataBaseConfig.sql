CREATE TABLE `USER`
(
    `id`        BIGINT NOT NULL COMMENT 'vk-id of user',
    `stateId`   INT    NOT NULL DEFAULT '0' COMMENT 'view state',
    `stateArgs` JSON   NOT NULL COMMENT 'args of current state',
    `bills`     JSON   NOT NULL COMMENT 'available bills ids',
    PRIMARY KEY (`id`)
);

CREATE TABLE `BILL`
(
    `id`             BIGINT      NOT NULL AUTO_INCREMENT COMMENT 'Bill id',
    `adminId`        BIGINT      NOT NULL COMMENT 'creator id',
    `name`           VARCHAR(50) NOT NULL COMMENT 'name of bill',
    `password`       VARCHAR(256) COMMENT 'password (can be empty)',
    `persons`        JSON        NOT NULL COMMENT 'json list of bill persons',
    `singleBillsIds` JSON        NOT NULL COMMENT 'json list of single bills',
    PRIMARY KEY (`id`)
);

CREATE TABLE `PERSON`
(
    `id`             BIGINT      NOT NULL AUTO_INCREMENT COMMENT 'id of person (bill_id:user_id)',
    `name`           VARCHAR(50) NOT NULL,
    `singleBillsIds` JSON        NOT NULL COMMENT 'json list of single bills',
    `billId`         BIGINT      NOT NULL,
    PRIMARY KEY (`id`)
);


CREATE TABLE `SINGLE_BILL`
(
    `id`            BIGINT  NOT NULL AUTO_INCREMENT,
    `billId`        BIGINT  NOT NULL,
    `persons`       JSON    NOT NULL COMMENT 'json list of bill persons',
    `fields`        JSON    NOT NULL COMMENT 'json list of bill fields',
    `fullValue`     REAL    NOT NULL DEFAULT '0',
    `isPersonField` BOOLEAN NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
);

CREATE TABLE `FIELD`
(
    `id`           BIGINT      NOT NULL AUTO_INCREMENT,
    `name`         VARCHAR(50) NOT NULL,
    `price`        DOUBLE      NOT NULL,
    `singleBillId` BIGINT      NOT NULL,
    `billId`       BIGINT      NOT NULL,
    PRIMARY KEY (`id`)
);
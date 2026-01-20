SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ============================================
-- USERS
-- ============================================
CREATE TABLE users (
    user_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) UNIQUE NOT NULL,
    email VARCHAR(30) UNIQUE NOT NULL,
    password_hash TEXT NOT NULL,
    profile_image_url TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================
-- CHATS
-- ============================================
CREATE TABLE chats (
    chat_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    is_group BOOLEAN NOT NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_chats_created_by
        FOREIGN KEY (created_by) REFERENCES users(user_id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================
-- CHAT MEMBERS
-- ============================================
CREATE TABLE chat_members (
    chat_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (chat_id, user_id),
    CONSTRAINT fk_chat_members_chat
        FOREIGN KEY (chat_id) REFERENCES chats(chat_id)
        ON DELETE CASCADE,
    CONSTRAINT fk_chat_members_user
        FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================
-- MESSAGES
-- ============================================
CREATE TABLE messages (
    message_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    chat_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    content TEXT,
    reply_to_id BIGINT UNSIGNED,
    is_deleted BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    edited_at TIMESTAMP NULL,
    CONSTRAINT fk_messages_chat
        FOREIGN KEY (chat_id) REFERENCES chats(chat_id)
        ON DELETE CASCADE,
    CONSTRAINT fk_messages_user
        FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON DELETE CASCADE,
    CONSTRAINT fk_messages_reply
        FOREIGN KEY (reply_to_id) REFERENCES messages(message_id)
        ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================
-- MESSAGES ATTACHMENTS
-- ============================================
CREATE TABLE messages_attachments (
    attachment_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    message_id BIGINT UNSIGNED NOT NULL,
    file_url TEXT NOT NULL,
    file_type VARCHAR(20),
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_messages_attachments_message
        FOREIGN KEY (message_id) REFERENCES messages(message_id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================
-- MESSAGES REACTIONS
-- ============================================
CREATE TABLE messages_reactions (
    reaction_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    message_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    emoji_code VARCHAR(20) NOT NULL,
    reacted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_messages_reactions_message
        FOREIGN KEY (message_id) REFERENCES messages(message_id)
        ON DELETE CASCADE,
    CONSTRAINT fk_messages_reactions_user
        FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

SET FOREIGN_KEY_CHECKS = 1;

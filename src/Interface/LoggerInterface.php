<?php
declare(strict_types=1);

namespace Logger\Interface;

use Logger\Enum\LogLevel;

/**
 * Interface for a logger that handles messages of various severity levels.
 *
 * Implementations of this interface provide methods to log messages 
 * at different levels of severity, ranging from debugging information 
 * to critical system failures.
 * 
 * @version 1.0
 * @author Ugo Brocard
 * @package Logger\Interface
 */
interface LoggerInterface
{
    /**
     * Logs a message with the emergency severity level.
     *
     * Example: "The server is down and all services are unavailable."
     *
     * @param string $message The log message.
     * @param array $context Contextual information for the log message.
     */
    public function emergency(string $message, array $context = []): void;

    /**
     * Logs a message with the alert severity level.
     *
     * Example: "Database connection pool is exhausted. Immediate action required."
     *
     * @param string $message The log message.
     * @param array $context Contextual information for the log message.
     */
    public function alert(string $message, array $context = []): void;

    /**
     * Logs a message with the critical severity level.
     *
     * Example: "Application component XYZ failed unexpectedly."
     *
     * @param string $message The log message.
     * @param array $context Contextual information for the log message.
     */
    public function critical(string $message, array $context = []): void;

    /**
     * Logs a message with the error severity level.
     *
     * Example: "Error processing user request: Invalid input format."
     *
     * @param string $message The log message.
     * @param array $context Contextual information for the log message.
     */
    public function error(string $message, array $context = []): void;

    /**
     * Logs a message with the warning severity level.
     *
     * Example: "Disk space is running low. Only 10% remaining."
     *
     * @param string $message The log message.
     * @param array $context Contextual information for the log message.
     */
    public function warning(string $message, array $context = []): void;

    /**
     * Logs a message with the notice severity level.
     *
     * Example: "API version 1.2 is deprecated and will be removed soon."
     *
     * @param string $message The log message.
     * @param array $context Contextual information for the log message.
     */
    public function notice(string $message, array $context = []): void;

    /**
     * Logs a message with the info severity level.
     *
     * Example: "User JohnDoe logged in successfully."
     *
     * @param string $message The log message.
     * @param array $context Contextual information for the log message.
     */
    public function info(string $message, array $context = []): void;

    /**
     * Logs a message with the debug severity level.
     *
     * Example: "Starting database query: SELECT * FROM users WHERE id = 1."
     *
     * @param string $message The log message.
     * @param array $context Contextual information for the log message.
     */
    public function debug(string $message, array $context = []): void;

    /**
     * Logs a message with a specified severity level.
     *
     * @param LogLevel $level The severity level of the log message.
     * @param string $message The log message.
     * @param array $context Contextual information for the log message.
     */
    public function log(LogLevel $level, string $message, array $context = []): void;
}
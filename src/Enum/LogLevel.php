<?php
declare(strict_types=1);

namespace Logger\Enum;

/**
 * Enum representing various levels of logging severity.
 *
 * This enumeration can be used to specify the severity of log messages,
 * typically in a logging framework or system. The levels are ordered
 * by severity, with `EMERGENCY` being the most critical and `DEBUG` being the least.
 * 
 * @version 1.0
 * @author Ugo Brocard
 * @package Logger\Enum
 */
enum LogLevel: string {
    /**
     * System is unusable. 
     * Example: Application or system crash.
     */
    case EMERGENCY = "emergency";

    /**
     * Action must be taken immediately.
     * Example: Database unavailable, immediate fix required.
     */
    case ALERT = "alert";

    /**
     * Critical conditions.
     * Example: Application component failure.
     */
    case CRITICAL = "critical";

    /**
     * Error conditions.
     * Example: Runtime error that does not require immediate action but should be logged and monitored.
     */
    case ERROR = "error";

    /**
     * Warning conditions.
     * Example: Potential issues that might lead to a problem.
     */
    case WARNING = "warning";

    /**
     * Normal but significant events.
     * Example: Usage of a deprecated API.
     */
    case NOTICE = "notice";

    /**
     * Informational messages.
     * Example: Application lifecycle events, such as startup or shutdown.
     */
    case INFO = "info";

    /**
     * Debug-level messages.
     * Example: Detailed debug information useful for troubleshooting.
     */
    case DEBUG = "debug";
}
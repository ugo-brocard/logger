<?php
declare(strict_types=1);

namespace Logger;

use Logger\Enum\LogLevel;
use Logger\Interface\LoggerInterface;

/**
 * Final implementation of the LoggerInterface.
 *
 * This class provides a concrete implementation of the LoggerInterface,
 * managing log messages of various severity levels. It includes static
 * configuration options for log file storage and retention.
 * 
 * @version 1.0
 * @author Ugo Brocard
 * @package Logger
 */
final class Logger implements LoggerInterface
{
    /**
     * Number of days to retain log files.
     * 
     * This static property determines how many days the logs will be kept
     * before being deleted or archived. Defaults to 7 days.
     *
     * @var int
     */
    public static int $logRetentionDays;

    /**
     * Path where log files are stored.
     * 
     * This static property specifies the directory where the log files
     * will be saved. It should be writable by the application.
     *
     * @var string
     */
    public static string $logStoragePath;

    /**
     * Constructor for initializing the logger's configuration.
     *
     * This constructor sets the storage path for log files and the 
     * retention period for keeping logs. Both properties are static 
     * and affect all instances of the logger.
     *
     * @param string $logStoragePath Path where log files will be stored.
     * @param int $logRetentionDays Number of days to retain log files (default: 7).
     */
    public function __construct(
        string $logStoragePath,
        int $logRetentionDays = 7,
    ) {
        self::$logStoragePath = $logStoragePath;
        self::$logRetentionDays = $logRetentionDays;

        $this->removeExpiredLog();
    }

    public function log(LogLevel $level, string $message, array $context = []): void
    {
        $logFile = $this->unsureLogFileExists();

        $content = json_decode(file_get_contents($logFile), true);
        $content[] = [
            "level" => $level->value,
            "message" => $message,
            "context" => $context,
            "datetime" => new \DateTimeImmutable()->format("Y-m-d H:i:s"),
        ];

        file_put_contents($logFile, json_encode($content, JSON_PRETTY_PRINT));
    }

    public function emergency(string $message, array $context = []): void
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    public function alert(string $message, array $context = []): void
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    public function critical(string $message, array $context = []): void
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    public function error(string $message, array $context = []): void
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    public function warning(string $message, array $context = []): void
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    public function notice(string $message, array $context = []): void
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    public function info(string $message, array $context = []): void
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    public function debug(string $message, array $context = []): void
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }

    /**
     * Removes log files that have exceeded the retention period.
     *
     * This method checks all the log files in the storage path and deletes the ones
     * that have surpassed the defined retention period ($logRetentionDays).
     * The log files are expected to be in the format `.log.json`.
     */
    protected function removeExpiredLog(): void
    {
        $retentionDeadline = new \DateTimeImmutable("-" . self::$logRetentionDays . " days");
        
        $logFiles = glob(rtrim(str_replace("\\", "/", self::$logStoragePath), "/") . "/*.log.json", GLOB_NOSORT);
        foreach ($logFiles as $logFile) {
            $fileCreation = new \DateTimeImmutable()->setTimestamp(filectime($logFile));

            if ($fileCreation > $retentionDeadline) {
                continue;
            }

            unlink($logFile);
        }
    }

    /**
     * Checks if a log file for the current date exists and creates it if necessary.
     * 
     * This method constructs the log file path using the current date (in `Y-m-d` format).
     * If the file exists, it returns the path to the file. If the file does not exist,
     * it attempts to create a new log file and writes an empty JSON array (`[]`) to it.
     *
     * @return string The path to the log file.
     * @throws \RuntimeException If the log file cannot be created or written to.
     */
    protected function unsureLogFileExists(): string
    {
        $filePath = rtrim(str_replace("\\", "/", self::$logStoragePath), "/") . "/" . new \DateTimeImmutable()->format("Y-m-d") . ".log.json";

        $matches = glob($filePath, GLOB_NOSORT);
        if (! empty($matches)) {
            return $matches[0];
        }

        if (file_put_contents($filePath, "[]") === false) {
            throw new \RuntimeException("Failed to write to log file at: {$filePath}");
        }

        return $filePath;
    }
}
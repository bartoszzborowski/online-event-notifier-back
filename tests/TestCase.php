<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use PHPUnit\Framework\ExpectationFailedException;
use Rebing\GraphQL\Support\Facades\GraphQL;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    /**
     * Helper to dispatch an internal GraphQL requests.
     *
     * @param  string  $query
     * @param  array  $options
     *   Supports the following options:
     *   - `expectErrors` (default: false): if no errors are expected but present, let's the test fail
     *   - `variables` (default: null): GraphQL variables for the query
     * @return array GraphQL result
     */
    protected function graphql(string $query, array $options = []): array
    {
        $expectErrors = $options['expectErrors'] ?? false;
        $variables = $options['variables'] ?? null;
        $result = GraphQL::query($query, $variables);
        $assertMessage = null;
        if (! $expectErrors && isset($result['errors'])) {
            $appendErrors = '';
            if (isset($result['errors'][0]['trace'])) {
                $appendErrors = "\n\n".$this->formatSafeTrace($result['errors'][0]['trace']);
            }
            $assertMessage = "Probably unexpected error in GraphQL response:\n"
                .var_export($result, true)
                .$appendErrors;
        }
        unset($result['errors'][0]['trace']);
        if ($assertMessage) {
            throw new ExpectationFailedException($assertMessage);
        }
        return $result;
    }

    /**
     * Helper to dispatch an HTTP GraphQL requests.
     *
     * @param  string  $query
     * @param  array  $options
     *   Supports the following options:
     *   - `httpStatusCode` (default: 200): the HTTP status code to expect
     * @return array GraphQL result
     */
    protected function httpGraphql(string $query, array $options = []): array
    {
        $expectedHttpStatusCode = $options['httpStatusCode'] ?? 200;
        $response = $this->call('GET', '/graphql', [
            'query' => $query,
        ]);
        $httpStatusCode = $response->getStatusCode();
        if ($expectedHttpStatusCode !== $httpStatusCode) {
            $result = $response->getData(true);
            $msg = var_export($result, true)."\n";
            $this->assertSame($expectedHttpStatusCode, $httpStatusCode, $msg);
        }
        return $response->getData(true);
    }


    /**
     * Converts the trace as generated from \GraphQL\Error\FormattedError::toSafeTrace
     * to a more human-readable string for a failed test.
     *
     * @param array $trace
     * @return string
     */
    private function formatSafeTrace(array $trace): string
    {
        return implode(
            "\n",
            array_map(function (array $row, int $index): string {
                $line = "#$index ";
                $line .= $row['file'] ?? '';
                if (isset($row['line'])) {
                    $line .= "({$row['line']}) :";
                }
                if (isset($row['call'])) {
                    $line .= ' '.$row['call'];
                }
                if (isset($row['function'])) {
                    $line .= ' '.$row['function'];
                }
                return $line;
            }, $trace, array_keys($trace))
        );
    }
}

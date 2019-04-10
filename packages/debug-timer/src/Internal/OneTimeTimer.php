<?php

declare(strict_types=1);

namespace Suin\Debug\Timer\Internal;

use LogicException;

final class OneTimeTimer
{
    /**
     * @var string
     */
    private $label;

    /**
     * @var bool
     */
    private $stopped = false;

    /**
     * @var Timer
     */
    private $timer;

    public function __construct(string $label)
    {
        $this->label = $label;
        $this->timer = new Timer($label);
    }

    public function stop(TimerStoppedObserver $observer): void
    {
        if ($this->stopped) {
            throw new LogicException(
                "The timer of '{$this->label}' has already stopped"
            );
        }
        $this->timer->stop($observer);
        $this->stopped = true;
    }
}

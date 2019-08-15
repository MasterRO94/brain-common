<?php

declare(strict_types=1);

namespace Brain\Common\Form\Type\Date;

use Brain\Common\Date\Range\DateTimeRange;
use Brain\Common\Date\Range\OpenEndedDateTimeRange;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

use DateTime;
use DateTimeInterface;

/**
 * A date range field that allows "from" and "to".
 */
final class DateRangeType extends AbstractType
{
    public const REGEX_DATE = '/^\d{4}-\d{2}-\d{2}(\s\d{2}:\d{2}:\d{2})?$/';

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /**
         * Now normalise the form data.
         */
        $normaliser = function (FormEvent $event): void {
            $data = $event->getData();

            // Set data to null so we can return anywhere for a null result.
            $event->setData(null);

            /** @var DateTimeInterface|null $from */
            $from = null;

            /** @var DateTimeInterface|null $to */
            $to = null;

            if (is_string($data)) {
                if (preg_match(self::REGEX_DATE, $data) !== 1) {
                    return;
                }

                $from = $this->convertStringToDateTime($data);
            } elseif (is_array($data)) {
                $from = $data['from'] ?? null;
                $to = $data['to'] ?? null;

                if (is_string($from)) {
                    $from = $this->convertStringToDateTime($from);
                } else {
                    $from = null;
                }

                if (is_string($to)) {
                    $to = $this->convertStringToDateTime($to);
                } else {
                    $to = null;
                }
            } else {
                return;
            }

            if ($from instanceof DateTimeInterface && $to instanceof DateTimeInterface) {
                $range = new DateTimeRange($from, $to);

                $event->setData($range);

                return;
            }

            if ($from instanceof DateTimeInterface && $to === null) {
                $range = OpenEndedDateTimeRange::createFrom($from);

                $event->setData($range);

                return;
            }

            if ($to instanceof DateTimeInterface && $from === null) {
                $range = OpenEndedDateTimeRange::createTo($to);

                $event->setData($range);

                return;
            }
        };

        $builder->addEventListener(FormEvents::PRE_SUBMIT, $normaliser);
    }

    /**
     * Convert the string to date time.
     */
    private function convertStringToDateTime(string $date): DateTimeInterface
    {
        $instance = new DateTime($date);

        return $instance;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'empty_data' => static function () {
                return null;
            },
        ]);
    }
}

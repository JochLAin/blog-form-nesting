<?php

namespace App\Form\DataTransformer;

use App\Entity\Memo;
use Symfony\Component\Form\DataTransformerInterface;

class AppModelTransformer implements DataTransformerInterface
{
    public function transform(mixed $value): array
    {
        $days = [];

        for ($day = 0; $day < 7; $day++) {
            $memoForDay = array_filter($value, fn (Memo $memo) => $day === $memo->getDay());
            uasort($memoForDay, fn ($a, $b) => $a->getId() - $b->getId());

            $days[] = [
                'day' => $day,
                'memos' => $memoForDay,
			];
		}

        return ['days' => $days];
    }

    public function reverseTransform(mixed $value): array
    {
        $data = [];

        foreach ($value['days'] as $item) {
            $day = $item['day'];
            foreach ($item['memos'] as $memo) {
                $memo->setDay($day);
                $data[] = $memo;
            }
        }

        return $data;
    }
}

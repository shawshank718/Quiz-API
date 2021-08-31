<?php


namespace App\Serializer;


use App\Entity\Quiz;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class QuizNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;
    private $gsmNormalizer;

    public function __construct(GetSetMethodNormalizer $gsmNormalizer)
    {
        $this->gsmNormalizer = $gsmNormalizer;
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Quiz;
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        $data = $this->gsmNormalizer->normalize($object, $format, $context);
        $questions = array_map(function ($quizQuestion) {
            return $quizQuestion->getQuestion();
        }, $object->getQuestions()->toArray());

        $data['questions'] = $this->normalizer->normalize($questions, $format, $context);

        return $data;
    }
}

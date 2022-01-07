<?php

namespace Tests\Unit\Controllers\Settings\Personalize\Pronouns\ViewHelpers;

use function env;
use Tests\TestCase;
use App\Models\Pronoun;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\Settings\Personalize\Pronouns\ViewHelpers\PersonalizePronounIndexViewHelper;

class PersonalizePronounIndexViewHelperTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_needed_for_the_view(): void
    {
        $pronoun = Pronoun::factory()->create();
        $array = PersonalizePronounIndexViewHelper::data($pronoun->account);
        $this->assertEquals(
            2,
            count($array)
        );
        $this->assertArrayHasKey('pronouns', $array);
        $this->assertEquals(
            [
                'settings' => env('APP_URL').'/settings',
                'personalize' => env('APP_URL').'/settings/personalize',
                'pronoun_store' => env('APP_URL').'/settings/personalize/pronouns',
            ],
            $array['url']
        );
    }

    /** @test */
    public function it_gets_the_data_needed_for_the_data_transfer_object(): void
    {
        $pronoun = Pronoun::factory()->create();
        $array = PersonalizePronounIndexViewHelper::dtoPronoun($pronoun);
        $this->assertEquals(
            [
                'id' => $pronoun->id,
                'name' => $pronoun->name,
                'url' => [
                    'update' => env('APP_URL').'/settings/personalize/pronouns/'.$pronoun->id,
                    'destroy' => env('APP_URL').'/settings/personalize/pronouns/'.$pronoun->id,
                ],
            ],
            $array
        );
    }
}
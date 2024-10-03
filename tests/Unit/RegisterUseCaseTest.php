<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Business\UseCases\Cases\RegisterUseCase;
use App\Persistence\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Exception;

class RegisterUseCaseTest extends TestCase
{
    private $repositoryMock;
    private $registerUseCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repositoryMock = $this->createMock(AuthRepositoryInterface::class);
        $this->registerUseCase = new RegisterUseCase($this->repositoryMock);
        Auth::shouldReceive('user')->andReturn((object) ['profile' => 'employee']);
    }

    public function testExecuteRegistersUserSuccessfully()
    {
        $dados = [
            'email' => 'test@example.com',
            'password' => 'StrongPassword123',
            'birthdate' => '15/08/1990'
        ];

        $this->repositoryMock->expects($this->once())
            ->method('register')
            ->with($dados);

        $this->registerUseCase->execute($dados);
        $this->assertTrue(true);
    }

    public function testExecuteThrowsExceptionIfPasswordContainsBirthYear()
    {
        $dados = [
            'email' => 'test@example.com',
            'password' => 'Password1990',
            'birthdate' => '15/08/1990'
        ];

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('A senha não pode conter partes do ano de nascimento.');

        $this->registerUseCase->execute($dados);
    }

    public function testExecuteThrowsExceptionIfNoUserIsLogged()
    {
        Auth::shouldReceive('user')->andReturn(null);

        $dados = [
            'email' => 'test@example.com',
            'password' => 'StrongPassword123',
            'birthdate' => '15/08/1990'
        ];

        $response = $this->registerUseCase->execute($dados);

        $this->assertIsBool($response, false);
    }
}

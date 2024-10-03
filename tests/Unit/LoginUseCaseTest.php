<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Business\UseCases\Cases\LoginUseCase;
use App\Persistence\Interfaces\AuthRepositoryInterface;
use Exception;

class LoginUseCaseTest extends TestCase
{
   private $repositoryMock;
   private $loginUseCase;

   protected function setUp(): void
   {
      parent::setUp();
      $this->repositoryMock = $this->createMock(AuthRepositoryInterface::class);
      $this->loginUseCase = new LoginUseCase($this->repositoryMock);
   }

   public function testExecuteCallsRepositoryLoginWithCorrectData()
   {
      $dados = [
         'email' => 'test@example.com',
         'password' => 'password123'
      ];

      $expectedResult = ['token' => 'fake-jwt-token'];
      $this->repositoryMock->expects($this->once())
         ->method('login')
         ->with($dados)
         ->willReturn($expectedResult);

      $result = $this->loginUseCase->execute($dados);
      $this->assertEquals($expectedResult, $result);
   }

   public function testExecuteFailsWithIncorrectData()
   {
      $dados = [
         'email' => 'wrong@example.com',
         'password' => 'wrongpassword'
      ];

      $this->repositoryMock->expects($this->once())
         ->method('login')
         ->with($dados)
         ->willReturn(array());

      $result = $this->loginUseCase->execute($dados);
      $this->assertEmpty($result);
   }

   public function testExecuteThrowsExceptionOnError()
   {
      $dados = [
         'email' => 'test@example.com',
         'password' => 'password123'
      ];

      $this->repositoryMock->expects($this->once())
         ->method('login')
         ->with($dados)
         ->willThrowException(new Exception('Login failed'));

      $this->expectException(Exception::class);
      $this->expectExceptionMessage('Login failed');

      $this->loginUseCase->execute($dados);
    }
}

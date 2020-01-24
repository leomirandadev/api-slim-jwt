<?
  namespace Middleware;

  use Jwt\JwtProcess;

  class Jwt {
    /**
     * Example middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next) {
        
        $token = $this->verifyHeader( $request->getHeaders() );
        if ( !$token ) {
            return $response->withJson( array("ok" => FALSE, "error" => "Não autorizado") );
        }

        $jwt = $this->validToken($token);
        if (!$jwt) {
            return $response->withJson( array("ok" => FALSE, "error" => "Token inválido ou expirado") );
        }

        $request = $request->withAttribute('payload', $jwt);
        return $next($request, $response);
    }

    /**
     * verifyHeader
     *
     * @param  array $header
     *
     * @return void
     */
    private function verifyHeader(array $header) {
        try {            
            $authorization = explode("Bearer ", $header["HTTP_AUTHORIZATION"][0]);
            if ($authorization) return $authorization[1];

        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * validToken
     *
     * @param  string $token
     *
     * @return void
     */
    private function validToken(string $token) {
        $jwt = new JwtProcess();
        if ($jwt->decode($token)){
            return $jwt->payload;
        }
        return false;
    }
  }
<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Servico;
use App\Models\Endereco;
use App\Models\Banco;
use App\Models\OpcaoParametro;

Use Carbon\Carbon;

class Entidade extends Model
{
    use SoftDeletes;

    const PRIMARY_KEY = 'pk_entidade';

    /**
     * <b>CREATED_AT</b> Renomeia o campo padrão created_at criado por padrão quando utilizamos o metodo timestamps() na migration
     */
    const CREATED_AT = 'dt_cadastro_entidade';

     /**
     * <b>UPDATED_AT</b>  Renomeia o campo padrão updated_at criado por padrão quando utilizamos o metodo timestamps() na migration
     */
    const UPDATED_AT = 'dt_atualizacao_entidade';

    /**
     * <b>DELETED_AT</b> Renomeia o campo padrão deleted_at criado por padrão quando utilizamos a Trait SoftDeletes na model
     * OBS: Essa trait habilita a exclusão logica de registros nativa do Laravel
     */
    const DELETED_AT = 'dt_exclusao_entidade';

     /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
     */
    protected $primaryKey = "pk_entidade";

     /**
     * <b>dates</b> Serve para tratar todos os campos de data para serem também um objeto do tipo Carbon(biblioteca de datas)
     */

    protected $dates = ['dt_cadastro_entidade', 'dt_atualizacao_entidade', 'dt_exclusao_entidade','dt_inicio_conv_entidade', 'dt_fim_conv_entidade' ];

     /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *
     */
    protected $fillable  = [
                            'pk_entidade',
                            'fk_pk_status_entidade',
                            'nm_entidade',
                            'ds_ativo_entidade',
                            'ds_email_entidade',
                            'sg_entidade',
                            'nm_resp_entidade',
                            'ds_telefone_entidade',
                            'ds_cargo_resp_entidade',
                            'dt_inicio_conv_entidade',
                            'dt_fim_conv_entidade',
							'fk_pk_banco',
                            'nr_agencia_bancaria',
                            'nr_conta_bancaria',
                            'ds_observacao_entidade',
                            'nr_max_prest_entidade',
                            'ds_observacao_entidade',

                        ];

    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
     */
    public $table = "sigmp_entidade";


    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
    */

    public $rules = [
        'nm_entidade'            => 'bail|required|min:5|max:150',
        'ds_ativo_entidade'      => 'bail|required|numeric',
        'fk_pk_status_entidade'  => 'bail|required|numeric|min:1',
        'nm_resp_entidade'       => 'bail|required|min:5|max:255',
        'ds_email_entidade'      => 'bail|nullable|email',
        'ds_telefone_entidade'   => 'bail|required',
        'dt_cadastro_entidade'   => 'bail|date',
        'dt_atualizacao_entidade'=> 'bail|date',
        'dt_exclusao_entidade'   => 'bail|date',
        'dt_inicio_conv_entidade'=> 'bail|required|date|date_format:Y-m-d',
        'dt_fim_conv_entidade'   => 'bail|nullable|date|date_format:Y-m-d',
    ];

    /**
     * <b>messages</b>  Atributo responsável em definir mensagem de validação de acordo com as regras especificadas no atributo $rules
    */
    public $messages = [
        'nm_entidade.required'             => 'O campo nome é obrigatório',
        'ds_ativo_entidade.required'       => 'O campo ativo é obrigatório',
        'ds_ativo_entidade.numeric'        => 'O campo ativo deve ser numerico',
        'fk_pk_status_entidade.required'   => 'O campo status é obrigatório',
        'fk_pk_status_entidade.numeric'    => 'O campo status deve ser numerico',
        'nm_resp_entidade.required'        => "O campo nomeResponsavel é obrigatório",
        'nm_resp_entidade.min'             => "O campo nomeResponsavel deve conter no minimo 5 caracteres",
        'nm_resp_entidade.max'             => "O campo nomeResponsavel deve conter no maximo 255 caracteres",
        'ds_telefone_entidade.required'    => 'O campo telefone é obrigatório',
        'dt_inicio_conv_entidade.required' => 'O campo dataInicioConvenio é obrigatório',
    ];

    /**
     * <b>hidden</b> Atributo responsável em esconder colunas que não deverão ser retornadas em uma requisição
    */
    protected $hidden  = [
        'rn',
    ];

    /**
     *<b>collection</b> Atributo responsável em informar o namespace e o arquivo do resorce
     * O mesmo é utilizado em forma de facade.
     * OBS: Responsável em retornar uma coleção com os alias(apelido) atribuitos para cada coluna.
     * Mais informações em https://laravel.com/docs/5.5/eloquent-resources
    */
    public $collection = "\App\Http\Resources\EntidadeResource::collection";

    /**
     * <b>resource</b>
     */
    public $resource = "\App\Http\Resources\EntidadeResource";

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
     */
    public $map = [
        'id'                       => 'pk_entidade',
        'status'                   => 'fk_pk_status_entidade',
        'nome'                     => 'nm_entidade',
        'email'                    => 'ds_email_entidade',
        'sigla'                    => 'sg_entidade',
        'tipoEntidade'             => '', // TODO: Implementar "tipoEntidade" em Entidade, usar opcao "tipoEntidade" já criada
        'nomeResponsavel'          => 'nm_resp_entidade',
        'telefone'                 => 'ds_telefone_entidade',
        'ativo'                    => 'ds_ativo_entidade',
        'cargoResponsavel'         => 'ds_cargo_resp_entidade',
        'dataInicioConvenio'       => 'dt_inicio_conv_entidade',
        'dataFimConvenio'          => 'dt_fim_conv_entidade',
        'capacidadeMaxPrestadores' => 'nr_max_prest_entidade',
		'banco'                    => 'fk_pk_banco',
		'agencia'                  => 'nr_agencia_bancaria',
		'conta'                    => 'nr_conta_bancaria',
        'observacoes'              => 'ds_observacao_entidade',
        'data_cadastro'            => 'dt_cadastro_entidade',
        'data_atualizacao'         => 'dt_atualizacao_entidade',
        'data_exclusao'            => 'dt_exclusao_entidade',
    ];

    /**
     * <b>getPrimaryKey</b> Método responsável em retornar o nome da primaryKey.
     * OBS: Não é recomendado que este atributo seja publico, por isso foi realizado o encapsulamento
    */

    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * <b>banco</b> Método responsável em definir o relacionamento entre as Models de Banco e Entidade e suas
     * respectivas tabelas.
     */
    public function banco()
    {
        return $this->hasOne(Banco::class,'pk_banco', 'fk_pk_banco');
        //return $this->belongsTo(Apenado::class,'pk_apenado', 'fk_pk_apenado');

    }

    /**
     * <b>servicos</b> Método responsável em definir o relacionamento entre as Models de Entidade e Serviço e suas
     * respectivas tabelas.
     */
    public function servicos()
	{
        return $this->hasMany(Servico::class, 'fk_pk_entidade', 'pk_entidade');
    }


	/**
     * <b>enderecos</b> Método responsável em definir o relacionamento entre as Models de Entidade e Endereco
     */
    public function enderecos()
    {
        return $this->morphMany(Endereco::class, 'dsTipoEndereco', 'ds_tipo_endereco', 'ds_id_endereco');
        //return $this->hasMany(Endereco::class, 'ds_id_endereco', 'pk_entidade', 'ds_tipo_endereco', 'entidade'); // TODO: verificar se funciona
    }

	/**
     * <b>Atividades</b> Método responsável em definir o relacionamento entre as Models de Entidade e Atividades
	 * para isso usando a classe OpcoesParametros
     */
    public function atividades()
    {
        return $this->morphMany(OpcaoParametro::class, 'ds_id_origem', 'pk_entidade', 'ds_tipo_opcao_parametro', 'atividades');
    }

    /**
     * <b>motivos</b> Método responsável em definir o relacionamento entre as models de Apenado, Custas, Entidade, Multa, Pecunia, Servico e
     *  Vara e  e suas respectivas tabelas.Este relacionamento é do tipo poliformico(polymorphic) sendo 1:N(1 para muitos) no caso da model
     *  de motivo(esta atrelado a ação realizada:ativar, inativar e excluir) a mesma poderá ser utilizada por Custas, Entidade, Multa, Pecunia, Servico , então para diferenciar o motivo
     *  é criado uma coluna ds_tipo_motivo e ds_id_motivo na tabela de motivo.
     *  Veja mais sobre em : https://laravel.com/docs/5.5/eloquent-relationships#polymorphic-relations
    */
    public function motivos()
    {

        return $this->morphMany(Motivo::class, 'dsTipoMotivo', 'ds_tipo_motivo', 'ds_id_motivo');
    }


     /**
     * <b>opcoesParametros</b> Método responsável em definir o relacionamento entre as models de Apenado, Custas, Entidade, Multa, Pecunia, Servico e
     *  Vara e  e suas respectivas tabelas.Este relacionamento é do tipo poliformico(polymorphic) sendo 1:N(1 para muitos) no caso da model
     *  Veja mais sobre em : https://laravel.com/docs/5.5/eloquent-relationships#polymorphic-relations
    */
    public function opcoesParametros()
    {

        return $this->morphMany(OpcaoParametro::class, 'dsTipoOpcaoParametro', 'ds_tipo_opcao_parametro', 'ds_id_opcao_parametro');
    }



    ///////////////////////////////////////////////////////////////////
    ///////////////////// REGRAS DE NEGOCIO ///////////////////////////
    ///////////////////////////////////////////////////////////////////


    /**
     * <b>obterParametros</b> Método resposavel por obter os parametros atrelados a classe Entidade e retornar os nomes dos mesmos.
     * @param  String  $Opcao
     * @return $paramObtido
     */
    public function obterParametros($opcao)
    {
        //Verificando se há a opcao passada no banco de dados
        $buscaId = DB::select('select PK_OPCAO from SIGMP_OPCAO where DS_OPCAO = ?', [$opcao]);

        if($buscaId)
        {
            $paramObtido = null ;
            //Obtendo o id da opcao
            $idOpcao = $buscaId['0']->pk_opcao;
            //Obtendo o id da Entidade
            $idEntidade = $this->original["pk_entidade"];
            $obtemParamsDaEntidade = DB::select('select FK_PK_PARAMETRO,PK_OPCAO_PARAMETRO,DS_ATIVO_OPCAO_PARAMETRO,DT_EXCLUSAO_OPCAO_PARAMETRO from SIGMP_OPCAO_PARAMETRO where fk_pk_opcao = ? AND DS_ID_OPCAO_PARAMETRO = ?', [$idOpcao, $idEntidade]);

            if(!empty($obtemParamsDaEntidade))
            {

                foreach($obtemParamsDaEntidade as $item)
                {
                    $obtemNumParametro =  $item->fk_pk_parametro ;
                    $obtemConteudoParam = DB::select('select PK_PARAMETRO,DS_PARAMETRO from sigmp_parametro where PK_PARAMETRO = ?', [$obtemNumParametro]);

                   if($item->dt_exclusao_opcao_parametro == null)
                    {
                        $obtemNomeIdParam['idOpcaoParametro'] = $item->pk_opcao_parametro;
                        $obtemNomeIdParam['opcaoParametroAtivo'] = $item->ds_ativo_opcao_parametro;
                        $obtemNomeIdParam['idOpcao'] = $idOpcao;


                        foreach($obtemConteudoParam as $item){
                            $obtemNomeIdParam['idParametro'] =  $item->pk_parametro;
                            $obtemNomeIdParam['nomeParametro'] =  $item->ds_parametro;
                            $paramObtido[] = $obtemNomeIdParam;
                        }
                    }
                }

                return $paramObtido;
            }
        }

        return ;

    }

     /**
     * <b>regraExclusao</b> Regras responsável em verificar se umaServico e seu historico podem ser excluidos logicamente.
     * REGRA: Para uma Servico ser excluida logicamente, a mesma deverá possuir apenas 1 registro em seu histórico e não deverá
     * possuir nenhum pagamento.
     *
     * @param  int  $id
     * @return $servico ou $error
     */

    public function regraExclusao($id)
    {
        //busca a servico informada
        $entidade = $this->find($id);
        //caso a entidade exista
        if($entidade != null)
        {
            $servicos  = $entidade->servicos()->count();

            if($servicos == 0)
            {
                return true;
            }

            $error['message'] = "A entidade não pode ser excluída, devido a possuir servico";
            $error['error']   = true;

            return $error;

        }

        $error['message'] = "A entidade informada não existe";
        $error['error']   = true;

        return $error;

    }

    }

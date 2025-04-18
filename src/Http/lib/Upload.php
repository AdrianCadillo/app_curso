<?php
namespace src\Http\lib;

trait Upload{

    use Request;
    /** PROPIEDADES */

    private String $NameFile = "archivo";

    private String $Destino = "assets/fotos/";

    private String|null $NombreDelArchivo = null;

    private array $TipoArchivosAceptables = ["png","jpg","jpeg"];


    /**
     * Subir los archivos al servidor
     */
    public function UploadFile():String{

      if($this->getFileSize($this->getNameFile()) > 0){ /// imagen.png
        
        $Extension = explode(".",$this->getFileName($this->getNameFile()))[1];

        if(in_array($Extension,$this->TipoArchivosAceptables)){
          
            if(!file_exists($this->Destino)){
                mkdir($this->Destino,0777,true);
            }
            /// nombre de la imagen
            $this->NombreDelArchivo = date("YmdHis").rand().".".$Extension;

            $this->Destino.=$this->NombreDelArchivo;

            if(move_uploaded_file($this->getContentFile($this->getNameFile()),$this->Destino)){
                return 'ok';
            }

            return 'error';
        }

        return 'no-accept';

      }

      return 'vacio';
    }

    /**
     * Get the value of NameFile
     *
     * @return String
     */
    public function getNameFile(): String
    {
        return $this->NameFile;
    }

    /**
     * Set the value of NameFile
     *
     * @param String $NameFile
     *
     * @return self
     */
    public function setNameFile(String $NameFile): self
    {
        $this->NameFile = $NameFile;

        return $this;
    }

    /**
     * Get the value of Destino
     *
     * @return String
     */
    public function getDestino(): String
    {
        return $this->Destino;
    }

    /**
     * Set the value of Destino
     *
     * @param String $Destino
     *
     * @return self
     */
    public function setDestino(String $Destino): self
    {
        $this->Destino = $Destino;

        return $this;
    }

    /**
     * Get the value of NombreDelArchivo
     *
     * @return String|null
     */
    public function getNombreDelArchivo(): String|null
    {
        return $this->NombreDelArchivo;
    }

    /**
     * Set the value of NombreDelArchivo
     *
     * @param String|null $NombreDelArchivo
     *
     * @return self
     */
    public function setNombreDelArchivo(String|null $NombreDelArchivo): self
    {
        $this->NombreDelArchivo = $NombreDelArchivo;

        return $this;
    }

    /**
     * Get the value of TipoArchivosAceptables
     *
     * @return array
     */
    public function getTipoArchivosAceptables(): array
    {
        return $this->TipoArchivosAceptables;
    }

    /**
     * Set the value of TipoArchivosAceptables
     *
     * @param array $TipoArchivosAceptables
     *
     * @return self
     */
    public function setTipoArchivosAceptables(array $TipoArchivosAceptables): self
    {
        $this->TipoArchivosAceptables = $TipoArchivosAceptables;

        return $this;
    }
}
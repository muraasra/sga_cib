<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvaluationRepository::class)]
class Evaluation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'evaluation', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stage $stage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $assuiduite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ponctualite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dis_pro_res_reg_sec = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $int_ent = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $res_hie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $esp_equi_ini = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $apt_exe_tac = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $org_pos_tra = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $app_soi_exe_tac = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rec_pro_the = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStage(): ?Stage
    {
        return $this->stage;
    }

    public function setStage(Stage $stage): static
    {
        $this->stage = $stage;

        return $this;
    }

    public function getAssuiduite(): ?string
    {
        return $this->assuiduite;
    }

    public function setAssuiduite(?string $assuiduite): static
    {
        $this->assuiduite = $assuiduite;

        return $this;
    }

    public function getPonctualite(): ?string
    {
        return $this->ponctualite;
    }

    public function setPonctualite(?string $ponctualite): static
    {
        $this->ponctualite = $ponctualite;

        return $this;
    }

    public function getDisProResRegSec(): ?string
    {
        return $this->dis_pro_res_reg_sec;
    }

    public function setDisProResRegSec(?string $dis_pro_res_reg_sec): static
    {
        $this->dis_pro_res_reg_sec = $dis_pro_res_reg_sec;

        return $this;
    }

    public function getIntEnt(): ?string
    {
        return $this->int_ent;
    }

    public function setIntEnt(?string $int_ent): static
    {
        $this->int_ent = $int_ent;

        return $this;
    }

    public function getResHie(): ?string
    {
        return $this->res_hie;
    }

    public function setResHie(?string $res_hie): static
    {
        $this->res_hie = $res_hie;

        return $this;
    }

    public function getEspEquiIni(): ?string
    {
        return $this->esp_equi_ini;
    }

    public function setEspEquiIni(?string $esp_equi_ini): static
    {
        $this->esp_equi_ini = $esp_equi_ini;

        return $this;
    }

    public function getAptExeTac(): ?string
    {
        return $this->apt_exe_tac;
    }

    public function setAptExeTac(?string $apt_exe_tac): static
    {
        $this->apt_exe_tac = $apt_exe_tac;

        return $this;
    }

    public function getOrgPosTra(): ?string
    {
        return $this->org_pos_tra;
    }

    public function setOrgPosTra(?string $org_pos_tra): static
    {
        $this->org_pos_tra = $org_pos_tra;

        return $this;
    }

    public function getAppSoiExeTac(): ?string
    {
        return $this->app_soi_exe_tac;
    }

    public function setAppSoiExeTac(?string $app_soi_exe_tac): static
    {
        $this->app_soi_exe_tac = $app_soi_exe_tac;

        return $this;
    }

    public function getRecProThe(): ?string
    {
        return $this->rec_pro_the;
    }

    public function setRecProThe(?string $rec_pro_the): static
    {
        $this->rec_pro_the = $rec_pro_the;

        return $this;
    }
}

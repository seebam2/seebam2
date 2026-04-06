import { Button } from "@/components/ui/button";
import { Card } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { useNavigate } from "react-router-dom";
import {
  Users, Shield, BarChart3, HeartPulse, Globe, Landmark,
  ChevronRight, CheckCircle2, ArrowRight, Zap, Lock, Smartphone,
} from "lucide-react";

const features = [
  { icon: Users, title: "Gestão de Associados", desc: "Cadastro inteligente com dependentes, histórico profissional, documentos digitalizados e controle de status em tempo real." },
  { icon: HeartPulse, title: "Motor de Benefícios", desc: "Automatize 100% da elegibilidade: regras dinâmicas, cálculo instantâneo de valores e descontos por categoria." },
  { icon: BarChart3, title: "Financeiro Completo", desc: "Mensalidades, cobranças automáticas, controle de inadimplência e relatórios gerenciais que economizam horas de trabalho." },
  { icon: Globe, title: "CMS Institucional", desc: "Site profissional integrado com notícias, eventos, documentos e editor visual — sem precisar de agência." },
  { icon: Shield, title: "Multi-Tenant Seguro", desc: "Cada sindicato com base 100% isolada e criptografada. Seus dados nunca se misturam com os de outro cliente." },
  { icon: Landmark, title: "Portal do Associado", desc: "Área exclusiva onde o associado consulta dados, emite boletos, agenda serviços e acompanha benefícios 24h." },
];

const plans = [
  {
    name: "Essencial",
    price: "R$ 690",
    period: "/mês",
    desc: "Ideal para sindicatos de pequeno porte que querem sair do papel",
    features: ["Até 500 associados", "3 usuários administrativos", "Módulos essenciais", "Hospedagem e backup inclusos", "Suporte por e-mail"],
    highlight: false,
  },
  {
    name: "Profissional",
    price: "R$ 1.490",
    period: "/mês",
    desc: "Para sindicatos que precisam de autonomia total",
    features: ["Até 5.000 associados", "15 usuários administrativos", "Todos os módulos + CMS", "Relatórios avançados", "Suporte prioritário por chat"],
    highlight: true,
  },
  {
    name: "Enterprise",
    price: "Sob consulta",
    period: "",
    desc: "Para grandes sindicatos ou federações com necessidades específicas",
    features: ["Associados ilimitados", "Usuários ilimitados", "Servidor próprio ou nuvem dedicada", "API completa + integrações", "SLA 99,99% + onboarding dedicado"],
    highlight: false,
  },
];

const stats = [
  { value: "14+", label: "Sindicatos confiam no Seebam" },
  { value: "18.000+", label: "Associados gerenciados" },
  { value: "99,97%", label: "Disponibilidade garantida" },
  { value: "R$ 2M+", label: "Processados mensalmente" },
];

export default function LandingPage() {
  const navigate = useNavigate();

  return (
    <div className="min-h-screen bg-background">
      {/* Navbar */}
      <header className="sticky top-0 z-50 border-b bg-background/80 backdrop-blur-md">
        <div className="max-w-7xl mx-auto flex items-center justify-between px-6 h-16">
          <div className="flex items-center gap-3">
            <div className="flex h-9 w-9 items-center justify-center rounded-lg bg-primary">
              <Landmark className="h-5 w-5 text-primary-foreground" />
            </div>
            <span className="text-lg font-bold text-foreground">Seebam</span>
          </div>
          <nav className="hidden md:flex items-center gap-8">
            <a href="#funcionalidades" className="text-sm text-muted-foreground hover:text-foreground transition-colors">Funcionalidades</a>
            <a href="#planos" className="text-sm text-muted-foreground hover:text-foreground transition-colors">Planos</a>
            <a href="#numeros" className="text-sm text-muted-foreground hover:text-foreground transition-colors">Números</a>
          </nav>
          <div className="flex items-center gap-3">
            <Button variant="ghost" onClick={() => navigate("/login")}>Entrar</Button>
            <Button onClick={() => navigate("/login")}>
              Começar agora <ArrowRight className="h-4 w-4" />
            </Button>
          </div>
        </div>
      </header>

      {/* Hero */}
      <section className="relative overflow-hidden">
        <div className="absolute inset-0 bg-gradient-to-b from-primary/5 to-transparent pointer-events-none" />
        <div className="max-w-7xl mx-auto px-6 pt-20 pb-24 text-center relative">
          <Badge variant="secondary" className="mb-6 px-4 py-1.5">
            <Zap className="h-3 w-3 mr-1.5" /> A plataforma #1 para gestão sindical no Brasil
          </Badge>
          <h1 className="text-4xl md:text-6xl font-bold text-foreground max-w-4xl mx-auto leading-tight tracking-tight">
            Seu sindicato merece uma <span className="text-primary">gestão de verdade</span>
          </h1>
          <p className="mt-6 text-lg text-muted-foreground max-w-2xl mx-auto leading-relaxed">
            Chega de planilhas, retrabalho e informações perdidas. 
            O Seebam centraliza associados, finanças, benefícios e atendimento em um só lugar — 
            com segurança de nível bancário e suporte humanizado.
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center mt-10">
            <Button size="lg" onClick={() => navigate("/login")} className="text-base px-8">
              Testar grátis por 14 dias <ChevronRight className="h-4 w-4" />
            </Button>
            <Button size="lg" variant="outline" className="text-base px-8">
              Agendar demonstração ao vivo
            </Button>
          </div>
          <div className="mt-8 flex items-center justify-center gap-6 text-sm text-muted-foreground">
            <span className="flex items-center gap-1.5"><CheckCircle2 className="h-4 w-4 text-primary" /> Sem cartão de crédito</span>
            <span className="flex items-center gap-1.5"><Lock className="h-4 w-4 text-primary" /> Dados criptografados</span>
            <span className="flex items-center gap-1.5"><Smartphone className="h-4 w-4 text-primary" /> Acesse de qualquer dispositivo</span>
          </div>
        </div>
      </section>

      {/* Stats */}
      <section id="numeros" className="border-y bg-muted/30">
        <div className="max-w-7xl mx-auto px-6 py-16">
          <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
            {stats.map((s) => (
              <div key={s.label} className="text-center">
                <p className="text-3xl md:text-4xl font-bold text-primary">{s.value}</p>
                <p className="mt-1 text-sm text-muted-foreground">{s.label}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Features */}
      <section id="funcionalidades" className="max-w-7xl mx-auto px-6 py-24">
        <div className="text-center mb-16">
          <Badge variant="outline" className="mb-4">Funcionalidades</Badge>
          <h2 className="text-3xl md:text-4xl font-bold text-foreground">Pare de improvisar. Comece a gerenciar.</h2>
          <p className="mt-4 text-muted-foreground max-w-xl mx-auto">
            Módulos integrados que eliminam retrabalho e dão visibilidade total da operação do seu sindicato.
          </p>
        </div>
        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
          {features.map((f) => (
            <Card key={f.title} className="p-6 hover:shadow-md transition-shadow border">
              <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 mb-4">
                <f.icon className="h-5 w-5 text-primary" />
              </div>
              <h3 className="text-base font-semibold text-card-foreground">{f.title}</h3>
              <p className="mt-2 text-sm text-muted-foreground leading-relaxed">{f.desc}</p>
            </Card>
          ))}
        </div>
      </section>

      {/* Pricing */}
      <section id="planos" className="bg-muted/30 border-y">
        <div className="max-w-7xl mx-auto px-6 py-24">
          <div className="text-center mb-16">
            <Badge variant="outline" className="mb-4">Planos transparentes</Badge>
            <h2 className="text-3xl md:text-4xl font-bold text-foreground">Invista menos do que uma folha de pagamento extra</h2>
            <p className="mt-4 text-muted-foreground max-w-2xl mx-auto">
              Preços justos que cabem no orçamento. Hospedamos seus dados com segurança total na nossa nuvem — 
              ou, se preferir, o sistema roda no seu próprio servidor com total controle e privacidade.
            </p>
          </div>
          <div className="grid md:grid-cols-3 gap-6 max-w-5xl mx-auto">
            {plans.map((plan) => (
              <Card
                key={plan.name}
                className={`p-8 flex flex-col ${plan.highlight ? "border-primary shadow-lg ring-1 ring-primary/20 relative" : ""}`}
              >
                {plan.highlight && (
                  <Badge className="absolute -top-3 left-1/2 -translate-x-1/2 px-4">Mais popular</Badge>
                )}
                <h3 className="text-lg font-semibold text-card-foreground">{plan.name}</h3>
                <p className="text-sm text-muted-foreground mt-1">{plan.desc}</p>
                <div className="mt-6 mb-6">
                  <span className="text-3xl font-bold text-foreground">{plan.price}</span>
                  <span className="text-muted-foreground">{plan.period}</span>
                </div>
                <ul className="space-y-3 flex-1">
                  {plan.features.map((feat) => (
                    <li key={feat} className="flex items-start gap-2 text-sm text-muted-foreground">
                      <CheckCircle2 className="h-4 w-4 text-primary shrink-0 mt-0.5" />
                      {feat}
                    </li>
                  ))}
                </ul>
                <Button
                  className="mt-8 w-full"
                  variant={plan.highlight ? "default" : "outline"}
                  onClick={() => navigate("/login")}
                >
                  {plan.price === "Sob consulta" ? "Falar com vendas" : "Começar agora"}
                </Button>
              </Card>
            ))}
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="max-w-7xl mx-auto px-6 py-24 text-center">
        <h2 className="text-3xl md:text-4xl font-bold text-foreground">
          Enquanto você lê isso, outro sindicato já está automatizando
        </h2>
        <p className="mt-4 text-muted-foreground max-w-xl mx-auto">
          Teste gratuitamente por 14 dias. Sem compromisso, sem cartão de crédito, sem surpresas. 
          Seus dados ficam seguros — conosco ou no seu próprio servidor.
        </p>
        <Button size="lg" className="mt-8 text-base px-10" onClick={() => navigate("/login")}>
          Começar agora — é grátis <ArrowRight className="h-4 w-4" />
        </Button>
      </section>

      {/* Footer */}
      <footer className="border-t bg-muted/30">
        <div className="max-w-7xl mx-auto px-6 py-10 flex flex-col md:flex-row items-center justify-between gap-4">
          <div className="flex items-center gap-2">
            <Landmark className="h-5 w-5 text-primary" />
            <span className="font-semibold text-foreground">Seebam</span>
          </div>
          <p className="text-sm text-muted-foreground">© 2026 Seebam. Todos os direitos reservados.</p>
        </div>
      </footer>
    </div>
  );
}

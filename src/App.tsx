/**
 * @license
 * SPDX-License-Identifier: Apache-2.0
 */

import { motion, useScroll, useTransform } from 'motion/react';
import { 
  Zap, 
  Cpu, 
  ShieldCheck, 
  ShieldAlert, 
  Camera, 
  TrendingUp, 
  ArrowRight, 
  MapPin, 
  Mail, 
  Menu, 
  CheckCircle2, 
  Clock,
  ExternalLink
} from 'lucide-react';
import { useState, useEffect } from 'react';

export default function App() {
  const [isScrolled, setIsScrolled] = useState(false);
  const { scrollYProgress } = useScroll();
  const opacity = useTransform(scrollYProgress, [0, 0.2], [1, 0]);

  useEffect(() => {
    const handleScroll = () => setIsScrolled(window.scrollY > 50);
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  const services = [
    {
      title: "Engenharia Elétrica (NR-10)",
      desc: "Projetos de alta complexidade e laudos técnicos especializados.",
      shortLabel: "[NR-10]",
      icon: <Zap className="w-5 h-5" />
    },
    {
      title: "Prevenção de Incêndio (NR-23)",
      desc: "Sistemas de detecção e combate conforme normas internacionais.",
      shortLabel: "[NR-23]",
      icon: <ShieldAlert className="w-5 h-5" />
    },
    {
      title: "Eficiência Energética",
      desc: "Otimização de consumo e redução de custos operacionais reais.",
      shortLabel: "[EFIC]",
      icon: <TrendingUp className="w-5 h-5" />
    },
    {
      title: "Infraestrutura de TI",
      desc: "Cabeamento estruturado e redes de alta disponibilidade.",
      shortLabel: "[ICT]",
      icon: <Cpu className="w-5 h-5" />
    },
    {
      title: "Segurança Eletrônica (CFTV)",
      desc: "Monitoramento inteligente e controle de acesso biométrico.",
      shortLabel: "[SEC]",
      icon: <Camera className="w-5 h-5" />
    },
    {
      title: "Recuperação de ICMS",
      desc: "Engenharia tributária focada em lucro operacional operacional.",
      shortLabel: "[ICMS]",
      icon: <CheckCircle2 className="w-5 h-5" />
    }
  ];

  return (
    <div className="min-h-screen flex flex-col bg-slate-dark text-text-primary selection:bg-electric-blue selection:text-slate-dark">
      {/* HEADER */}
      <header className={`fixed top-0 left-0 w-full z-50 transition-all duration-300 h-20 border-b border-border flex items-center justify-between px-10 ${isScrolled ? 'bg-slate-dark/95 backdrop-blur shadow-2xl' : 'bg-transparent'}`}>
        <div className="flex items-center gap-3 group cursor-pointer">
          <div className="w-8 h-8 bg-electric-blue flex items-center justify-center rounded-sm text-slate-dark font-bold text-lg">
            CM
          </div>
          <span className="font-extrabold text-xl tracking-tighter uppercase whitespace-nowrap">C&M GLOBAL SERVICES</span>
        </div>

        <nav className="hidden md:flex items-center gap-8">
          {['Início', 'Serviços', 'SST', 'Sobre', 'Contato'].map((item, i) => (
            <a key={item} href="#" className={`text-sm font-medium uppercase tracking-widest transition-colors ${i === 0 ? 'text-electric-blue' : 'text-text-secondary hover:text-text-primary'}`}>
              {item}
            </a>
          ))}
        </nav>

        <div className="md:hidden">
          <Menu className="w-6 h-6 text-text-primary" />
        </div>
      </header>

      <main className="flex-grow">
        {/* HERO SECTION */}
        <section className="min-h-[70vh] flex items-center px-10 pt-20">
          <div className="container mx-auto grid lg:grid-cols-2 gap-16 items-center">
            <motion.div 
              initial={{ opacity: 0, x: -50 }}
              animate={{ opacity: 1, x: 0 }}
              transition={{ duration: 0.8 }}
              className="space-y-8 hero-content"
            >
              <h1 className="text-6xl md:text-7xl font-bold leading-[1.1] tracking-tighter">
                Engenharia <br/> Conectada ao <br/>
                <span className="text-electric-blue">Amanhã</span>.
              </h1>
              
              <p className="text-text-secondary text-lg leading-relaxed max-w-md">
                Soluções integradas em infraestrutura física e digital com foco em Segurança do Trabalho e Eficiência Energética.
              </p>
              
              <div className="flex flex-wrap items-center gap-4 pt-4">
                <button className="btn-primary">
                  Solicitar Consultoria
                </button>
                <button className="btn-secondary">
                  Ver Portfólio
                </button>
              </div>
            </motion.div>

            <motion.div 
              initial={{ opacity: 0, scale: 0.9 }}
              animate={{ opacity: 1, scale: 1 }}
              transition={{ duration: 1 }}
              className="grid grid-cols-2 gap-4 services-grid"
            >
              {services.slice(0, 4).map((service, i) => (
                <div key={i} className="service-card group">
                  <span className="font-mono text-electric-blue text-[10px] mb-2 block tracking-widest uppercase">{service.shortLabel}</span>
                  <h3 className="text-text-primary text-base font-bold mb-2">{service.title}</h3>
                  <p className="text-text-secondary text-xs leading-relaxed">{service.desc}</p>
                </div>
              ))}
            </motion.div>
          </div>
        </section>

        {/* STATS BAR */}
        <section className="h-32 bg-slate-surface border-t border-border flex items-center px-10">
          <div className="container mx-auto flex justify-around items-center">
            {[
              { val: "+15", label: "Anos de Mercado" },
              { val: "+500", label: "Clientes Ativos" },
              { val: "24/7", label: "Suporte Técnico" },
              { val: "ISO 9001", label: "Qualidade Certificada" }
            ].map((stat, i) => (
              <div key={i} className="text-center group">
                <div className="font-mono text-3xl md:text-4xl text-electric-blue font-bold tracking-tight">
                  {stat.val}
                </div>
                <div className="text-[10px] uppercase tracking-widest text-text-secondary mt-1 group-hover:text-text-primary transition-colors">
                  {stat.label}
                </div>
              </div>
            ))}
          </div>
        </section>

        {/* SOBRE SECTION (NEW) */}
        <section id="sobre" className="py-24 px-10 border-t border-border">
          <div className="container mx-auto grid lg:grid-cols-2 gap-20 items-center">
            <div className="space-y-8">
              <span className="font-mono text-electric-blue text-xs uppercase tracking-[0.3em] font-bold">About / SST</span>
              <h2 className="text-4xl md:text-5xl font-bold tracking-tighter leading-tight">
                Segurança Operacional e <br/>
                <span className="text-electric-blue">Excelência Técnica</span>.
              </h2>
              <div className="space-y-6 text-text-secondary text-lg leading-relaxed">
                <p>A C&M Global Services integra as normas críticas de <strong>Segurança e Saúde no Trabalho (SST)</strong> diretamente na espinha dorsal da sua infraestrutura física e digital.</p>
                <p>Nossa engenharia não apenas resolve problemas técnicos, ela garante a continuidade dos negócios através de conformidade rigorosa e inovação constante.</p>
              </div>
              <div className="flex gap-10 pt-4">
                <div className="flex flex-col">
                  <span className="text-text-primary font-bold text-lg leading-none">NR-10 / NR-23</span>
                  <span className="text-[11px] uppercase tracking-widest text-text-secondary mt-2">Normas Regulamentadoras</span>
                </div>
                <div className="flex flex-col border-l border-border pl-10">
                  <span className="text-text-primary font-bold text-lg leading-none">360º Vision</span>
                  <span className="text-[11px] uppercase tracking-widest text-text-secondary mt-2">Consultoria Integrada</span>
                </div>
              </div>
            </div>
            <div className="relative group">
               <div className="aspect-[4/3] bg-slate-surface border border-border rounded-sm overflow-hidden p-2">
                 <img 
                    src="https://picsum.photos/seed/industrial-eng/800/600" 
                    alt="Engineers" 
                    className="w-full h-full object-cover grayscale opacity-50 group-hover:opacity-80 transition-opacity"
                    referrerPolicy="no-referrer"
                 />
               </div>
               <div className="absolute -bottom-6 -left-6 bg-electric-blue text-slate-dark p-6 font-bold tracking-tighter text-2xl">
                  RISK ZERO <br/> POLICY
               </div>
            </div>
          </div>
        </section>

        {/* SERVICES EXPANSION / CONTACT CTA */}
        <section id="contato" className="py-24 px-10 border-t border-border bg-slate-surface">
          <div className="container mx-auto">
             <div className="max-w-4xl mx-auto text-center space-y-10">
                <h2 className="text-5xl md:text-6xl font-bold tracking-tighter">
                  Pronto para a <br/> <span className="text-electric-blue">Evolução Instrumental?</span>
                </h2>
                <p className="text-text-secondary text-xl max-w-2xl mx-auto">
                  Do chão de fábrica à nuvem, nossa equipe está pronta para elevar os padrões da sua operação.
                </p>
                <div className="flex flex-col items-center gap-6">
                  <button className="btn-primary flex items-center gap-3 text-xl px-12 py-5">
                    Fale com um Especialista <ArrowRight className="w-6 h-6" />
                  </button>
                  <span className="text-xs font-mono text-text-secondary uppercase tracking-[0.2em]">Response Time: &lt; 45 Minutes</span>
                </div>
             </div>
          </div>
        </section>
      </main>

      <footer className="h-20 px-10 flex items-center justify-between border-t border-border bg-slate-dark text-text-secondary text-xs">
        <div>
          &copy; {new Date().getFullYear()} C&M Global Services - Todos os direitos reservados.
        </div>
        <div className="hidden md:flex items-center gap-8">
          <span>Av. das Nações, 1200 - SP</span>
          <span>comercial@cmglobalservices.com.br</span>
          <span className="font-bold border border-text-secondary px-1.5 py-0.5 rounded-sm text-[10px]">ISO 9001:2015</span>
        </div>
      </footer>
    </div>
  );
}

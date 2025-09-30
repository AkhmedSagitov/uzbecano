declare module 'svgstore' {
  interface SVGStoreOptions {
    inline?: boolean;
    svgAttrs?: boolean|object;
  }

  interface SVGStore {
    add(id: string, svg: string): this;

    toString(): string;
  }

  function svgstore(options?: SVGStoreOptions): SVGStore;

  export = svgstore;
}

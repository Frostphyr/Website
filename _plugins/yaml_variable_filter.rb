module Jekyll

    module YamlVariableFilter

      def render_variables(input)
        if (!input.nil?)
          indices = (0 ... input.length).find_all { |i| input[i,1] == '%' }
          if indices.length >= 2
            page = @context.registers[:page]
            indices.each_index {
              |i|
              if i > 0
                name = input[indices[i - 1] + 1..indices[i] - 1].downcase;
                if page.key?(name)
                  output = input.dup;
                  output[indices[i - 1]..indices[i]] = page[name]
                  return render_variables(output)
                end
              end
            }
          end
        end
        input
      end

    end

  end
  
  Liquid::Template.register_filter(Jekyll::YamlVariableFilter)